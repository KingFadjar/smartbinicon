const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;
const axios = require('axios');
const fs = require('fs');
const csv = require('csv-writer').createObjectCsvWriter;

// Memuat informasi koneksi dan lokasi dari locations.json
const locationsPath = path.join(__dirname, 'data', 'locations.json');
let locationsConfig = JSON.parse(fs.readFileSync(locationsPath, 'utf8'));

app.use(express.static(path.join(__dirname, 'public')));
app.use(express.json());

app.get('/', (req, res) => {
    res.sendFile(path.join(__dirname, 'public', 'index.html'));
});

app.get('/locations', (req, res) => {
    try {
        res.json(locationsConfig.tbl_dir_bps2023);
    } catch (error) {
        console.error('Error dalam pemrosesan lokasi:', error);
        res.status(500).json({ error: 'Internal Server Error' });
    }
});

app.post('/updateLatLng', async (req, res) => {
    try {
        const locationsWithNullLatLng = locationsConfig.tbl_dir_bps2023.filter(location => location.latlng === null);

        const csvWriter = csv.createObjectCsvWriter({
            path: path.join(__dirname, 'public', 'output.csv'),
            header: [
                { id: 'id', title: 'ID' },
                { id: 'nama_perusahaan', title: 'Nama Perusahaan' },
                { id: 'industri', title: 'Industri' },
                { id: 'tipe_industri', title: 'Tipe Industri' },
                { id: 'alamat', title: 'Alamat' },
                { id: 'telepon', title: 'Telepon' },
                { id: 'email', title: 'Email' },
                { id: 'createdate', title: 'CreateDate' },
                { id: 'latlng', title: 'LatLng' },
            ],
        });

        for (const location of locationsWithNullLatLng) {
            try {
                // Skip data jika kolom penting kosong
                if (!location.nama_perusahaan || !location.industri || !location.tipe_industri || !location.alamat) {
                    console.warn(`Data tidak lengkap untuk ID ${location.id}, melewatkan geocoding.`);
                    continue;
                }

                const response = await axios.get(`https://nominatim.openstreetmap.org/search`, {
                    params: {
                        q: location.alamat,
                        format: 'json',
                    },
                });

                if (response.data.length > 0) {
                    const coordinates = `${parseFloat(response.data[0].lat)}, ${parseFloat(response.data[0].lon)}`;

                    const updatedLocation = { ...location, latlng: coordinates };

                    const csvData = {
                        id: updatedLocation.id,
                        nama_perusahaan: updatedLocation.nama_perusahaan,
                        industri: updatedLocation.industri,
                        tipe_industri: updatedLocation.tipe_industri,
                        alamat: updatedLocation.alamat,
                        telepon: updatedLocation.telepon,
                        email: updatedLocation.email,
                        createdate: updatedLocation.createdate,
                        latlng: updatedLocation.latlng,
                    };

                    await csvWriter.writeRecords([csvData]);

                    console.log(`LatLng diperbarui untuk ${location.alamat}:`, updatedLocation);
                } else {
                    console.error(`Geocoding gagal untuk ${location.alamat}`);
                    // Set nilai latlng ke nilai default atau kosong sesuai kebutuhan Anda
                    const updatedLocation = { ...location, latlng: '' };
                    console.warn(`Geocoding gagal untuk ${location.alamat}, melewatkan.`);
                }
            } catch (error) {
                console.error(`Error selama geocoding untuk ${location.alamat}:`, error.message);
                // Set nilai latlng ke nilai default atau kosong sesuai kebutuhan Anda
                const updatedLocation = { ...location, latlng: '' };
                console.warn(`Geocoding gagal untuk ${location.alamat}, melewatkan.`);
            }
        }

        res.status(204).json({ message: 'LatLng berhasil diperbarui' });
    } catch (error) {
        console.error('Error di /updateLatLng:', error);
        res.status(500).json({ error: 'Internal Server Error' });
    }
});

app.listen(PORT, () => {
    console.log(`Server berjalan di port ${PORT}`);
});
