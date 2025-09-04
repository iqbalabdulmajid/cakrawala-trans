# =============================================================================
# IMPORTS - Mengimpor semua library yang kita butuhkan
# =============================================================================
from flask import Flask, request, jsonify
import pandas as pd
from sklearn.preprocessing import StandardScaler, OneHotEncoder
from sklearn.compose import ColumnTransformer
from sklearn.pipeline import Pipeline
from sklearn.neighbors import NearestNeighbors
import numpy as np
import os # Untuk menyimpan data secara persisten
from flask_cors import CORS
import pytesseract
from PIL import Image
import io
import re # Regular Expression untuk mencari NIK

# =============================================================================
# INISIALISASI APLIKASI DAN DATA GLOBAL
# =============================================================================
app = Flask(__name__)
CORS(app, resources={r"/api/*": {"origins": "*"}})

# Lokasi file untuk menyimpan data agar tidak hilang saat server restart
DATA_FILE = 'cars_data.json'

# Variabel global untuk menyimpan data dan model
CARS_DATA = [] # Data mentah dari Laravel
cars_df = pd.DataFrame() # DataFrame untuk diproses oleh model
knn_pipeline = None # Pipeline yang berisi preprocessor dan model KNN
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

@app.route('/api/ocr', methods=['POST'])
def process_ocr():
    # Pastikan file gambar ada di dalam request
    if 'ktp_image' not in request.files:
        return jsonify({'error': 'File gambar KTP tidak ditemukan'}), 400

    file = request.files['ktp_image']

    try:
        # Baca gambar menggunakan Pillow
        image = Image.open(io.BytesIO(file.read()))

        # Gunakan Tesseract untuk mengekstrak semua teks dari gambar
        # Tentukan bahasa ke 'ind' untuk hasil yang lebih akurat
        text = pytesseract.image_to_string(image, lang='ind')

        # --- Logika Ekstraksi NIK dan Nama ---
        nik = None
        nama = None

        lines = text.split('\n')
        for i, line in enumerate(lines):
            # 1. Cari NIK menggunakan Regular Expression (mencari 16 digit angka)
            if re.search(r'\d{16}', line):
                nik_match = re.search(r'\d{16}', line)
                if nik_match:
                    nik = nik_match.group(0)

            # 2. Cari Nama (biasanya berada di baris setelah "Nama")
            if "Nama" in line and (i + 1) < len(lines):
                # Ambil teks setelah "Nama", hilangkan whitespace, dan ":"
                nama_line = line.split("Nama")[-1].strip()
                if nama_line.startswith(':'):
                    nama_line = nama_line[1:].strip()

                if nama_line: # Jika nama ada di baris yang sama
                    nama = nama_line
                else: # Jika nama ada di baris berikutnya
                    nama = lines[i+1].strip()

        return jsonify({
            'nik': nik,
            'nama': nama,
            'raw_text': text # Kirim juga teks mentah untuk debugging
        })

    except Exception as e:
        return jsonify({'error': str(e)}), 500
# =============================================================================
# FUNGSI-FUNGSI BANTUAN (HELPER)
# =============================================================================
def save_data_to_file():
    """Menyimpan data mobil ke dalam file JSON."""
    global cars_df
    if not cars_df.empty:
        cars_df.to_json(DATA_FILE, orient='records', indent=4)
        print(f"Data disimpan ke {DATA_FILE}")

def load_data_from_file():
    """Memuat data mobil dari file JSON saat aplikasi pertama kali dijalankan."""
    global CARS_DATA, cars_df
    if os.path.exists(DATA_FILE):
        try:
            CARS_DATA = pd.read_json(DATA_FILE).to_dict('records')
            cars_df = pd.DataFrame(CARS_DATA)
            print(f"Data berhasil dimuat dari {DATA_FILE}")
            return True
        except Exception as e:
            print(f"Gagal memuat data: {e}")
            return False
    return False

def retrain_model():
    """
    Fungsi inti untuk melatih ulang model KNN setiap kali data berubah.
    """
    global cars_df, knn_pipeline

    if not CARS_DATA:
        print("Data mobil kosong, model tidak bisa dilatih.")
        knn_pipeline = None
        return

    print("Memulai proses training ulang model KNN...")
    cars_df = pd.DataFrame(CARS_DATA)

    # Tentukan jumlah tetangga (k) secara dinamis
    n_samples = len(cars_df)
    k = min(n_samples, 3)

    if k < 1:
        print("Tidak cukup data untuk melatih model (k < 1).")
        knn_pipeline = None
        return

    numeric_features = ['year', 'rental_price']
    categorical_features = ['brand', 'model']

    numeric_transformer = StandardScaler()
    categorical_transformer = OneHotEncoder(handle_unknown='ignore')

    preprocessor = ColumnTransformer(
        transformers=[
            ('num', numeric_transformer, numeric_features),
            ('cat', categorical_transformer, categorical_features)
        ])

    knn_pipeline = Pipeline(steps=[
        ('preprocessor', preprocessor),
        ('knn', NearestNeighbors(n_neighbors=k, metric='euclidean'))
    ])

    knn_pipeline.fit(cars_df)

    save_data_to_file()
    print(f"Training ulang model KNN selesai dengan k={k}.")

# =============================================================================
# ENDPOINTS UNTUK SINKRONISASI DATA DARI LARAVEL
# =============================================================================

@app.route('/api/car/add', methods=['POST'])
def add_car():
    new_car_data = request.json
    if new_car_data:
        if any(c['id'] == new_car_data['id'] for c in CARS_DATA):
             return jsonify({"status": "error", "message": "Car with this ID already exists"}), 409

        CARS_DATA.append(new_car_data)
        retrain_model()
        return jsonify({"status": "success", "message": "Mobil berhasil ditambahkan ke API"}), 201
    return jsonify({"status": "error", "message": "Data tidak valid"}), 400

@app.route('/api/car/update/<int:car_id>', methods=['POST'])
def update_car(car_id):
    update_data = request.json
    car_found = False
    for car in CARS_DATA:
        if car['id'] == car_id:
            car.update(update_data)
            car_found = True
            break

    if car_found:
        retrain_model()
        return jsonify({"status": "success", "message": "Mobil berhasil diupdate di API"})
    return jsonify({"status": "error", "message": "Mobil tidak ditemukan"}), 404

@app.route('/api/car/delete/<int:car_id>', methods=['POST'])
def delete_car(car_id):
    global CARS_DATA
    original_count = len(CARS_DATA)
    CARS_DATA = [car for car in CARS_DATA if car['id'] != car_id]

    if len(CARS_DATA) < original_count:
        retrain_model()
        return jsonify({"status": "success", "message": "Mobil berhasil dihapus dari API"})
    return jsonify({"status": "error", "message": "Mobil tidak ditemukan"}), 404

# === ENDPOINT BARU UNTUK SINKRONISASI ===
@app.route('/api/cars/sync', methods=['POST'])
def sync_cars():
    """Endpoint untuk menerima SEMUA data mobil dari Laravel untuk sinkronisasi penuh."""
    global CARS_DATA
    all_cars_data = request.json
    if isinstance(all_cars_data, list):
        CARS_DATA = all_cars_data
        print(f"Menerima {len(CARS_DATA)} mobil untuk sinkronisasi.")
        retrain_model()
        return jsonify({"status": "success", "message": f"{len(CARS_DATA)} mobil berhasil disinkronkan."}), 200
    return jsonify({"status": "error", "message": "Data tidak valid, harus berupa list."}), 400

# =============================================================================
# ENDPOINT UTAMA UNTUK REKOMENDASI KNN
# =============================================================================

@app.route('/api/recommend', methods=['GET'])
def recommend():
    if knn_pipeline is None or cars_df.empty:
        return jsonify({"error": "Model belum siap atau tidak ada data mobil. Silakan tambahkan mobil dari dashboard admin."}), 503

    filtered_df = cars_df.copy()

    # Filter berdasarkan merek jika parameter diberikan
    if request.args.get('brand'):
        selected_brand = request.args.get('brand').lower().strip()
        filtered_df = filtered_df[filtered_df['brand'].str.lower().str.strip() == selected_brand]

    # Filter berdasarkan model jika parameter diberikan
    if request.args.get('model'):
        selected_model = request.args.get('model').lower().strip()
        filtered_df = filtered_df[filtered_df['model'].str.lower().str.strip() == selected_model]

    if request.args.get('rental_price'):
        try:
            max_price = float(request.args.get('rental_price'))
            if max_price > 0:
                filtered_df = filtered_df[filtered_df['rental_price'] <= max_price]
        except (ValueError, TypeError):
            pass

    if filtered_df.empty:
        return jsonify([])

    try:
        user_prefs = {
            'brand': request.args.get('brand', filtered_df['brand'].mode()[0]),
            'model': request.args.get('model', filtered_df['model'].mode()[0]),
            'year': float(request.args.get('year', filtered_df['year'].mean())),
            'rental_price': float(request.args.get('rental_price', filtered_df['rental_price'].mean()))
        }
    except Exception as e:
        return jsonify({"error": f"Parameter tidak valid: {e}"}), 400

    user_df = pd.DataFrame([user_prefs])

    n_samples_filtered = len(filtered_df)
    k = min(n_samples_filtered, 3)
    if k < 1:
        return jsonify([])

    preprocessor = knn_pipeline.named_steps['preprocessor']
    temp_knn = NearestNeighbors(n_neighbors=k, metric='euclidean')
    filtered_data_transformed = preprocessor.transform(filtered_df)
    temp_knn.fit(filtered_data_transformed)
    user_transformed = preprocessor.transform(user_df)
    distances, indices = temp_knn.kneighbors(user_transformed)

    recommended_cars_df = filtered_df.iloc[indices[0]]

    return jsonify(recommended_cars_df.to_dict(orient='records'))

# =============================================================================
# MENJALANKAN APLIKASI
# =============================================================================
if __name__ == '__main__':
    if load_data_from_file():
        retrain_model()

    app.run(port=5001, debug=True)
