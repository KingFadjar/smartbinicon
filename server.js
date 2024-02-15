const express = require('express');
const path = require('path');
const app = express();
const PORT = process.env.PORT || 3000;
const axios = require('axios');
const fs = require('fs');
const createCsvWriter = require('csv-writer').createObjectCsvWriter;

const locationsPath = path.join(__dirname, 'data', 'locations.json');
const locationsConfig = JSON.parse(fs.readFileSync(locationsPath, 'utf8'));

app.use(express.static(path.join(__dirname, 'public')));
app.use(express.json());

// Fungsi untuk mendapatkan latlng berdasarkan nama perusahaan dan alamat
async function getLatLng(namaPerusahaan, alamat) {
    try {
        const response = await axios.get('https://nominatim.openstreetmap.org/search', {
            params: {
                q: `${namaPerusahaan}, ${alamat}`,
                format: 'json',
                addressdetails: 1,
                extratags: 1,
            },
        });

        if (response.data.length > 0) {
            const lat = parseFloat(response.data[0].lat);
            const lon = parseFloat(response.data[0].lon);
            return `${lat}, ${lon}`;
        }

        console.warn(`Gagal mendapatkan latlng untuk ${namaPerusahaan}, ${alamat}.`);
        return null;
    } catch (error) {
        console.error(`Error mendapatkan latlng untuk ${namaPerusahaan}, ${alamat}:`, error.message);
        return null;
    }
}

// Fungsi alternatif untuk mendapatkan latlng
async function getAlternativeLatLng(namaPerusahaan, alamat) {
    try {
        // Coba geocoding dengan nama perusahaan dan alamat
        const response1 = await axios.get('https://nominatim.openstreetmap.org/search', {
            params: {
                q: `${namaPerusahaan}, ${alamat}`,
                format: 'json',
                addressdetails: 1,
                extratags: 1,
            },
        });

        // Cek jika berhasil mendapatkan latlng
        if (response1.data.length > 0) {
            const lat = parseFloat(response1.data[0].lat);
            const lon = parseFloat(response1.data[0].lon);
            return `${lat}, ${lon}`;
        }

        // Jika gagal, coba dengan nama perusahaan sebagai alamat dan sebaliknya
        const response2 = await axios.get('https://nominatim.openstreetmap.org/search', {
            params: {
                q: `${alamat}, ${namaPerusahaan}`,
                format: 'json',
                addressdetails: 1,
                extratags: 1,
            },
        });

        // Cek jika berhasil mendapatkan latlng
        if (response2.data.length > 0) {
            const lat = parseFloat(response2.data[0].lat);
            const lon = parseFloat(response2.data[0].lon);
            return `${lat}, ${lon}`;
        }

        console.warn(`Gagal mendapatkan latlng alternatif untuk ${namaPerusahaan}, ${alamat}.`);
        return null;
    } catch (error) {
        console.error(`Error mendapatkan latlng alternatif untuk ${namaPerusahaan}, ${alamat}:`, error.message);
        return null;
    }
}

// Fungsi untuk mendapatkan latlng berdasarkan koordinat tengah (contoh: Jakarta)
async function getFallbackLatLng() {
    try {
        const response = await axios.get('https://nominatim.openstreetmap.org/search', {
            params: {
                q: 'Jakarta',
                format: 'json',
                addressdetails: 1,
                extratags: 1,
            },
        });

        if (response.data.length > 0) {
            const lat = parseFloat(response.data[0].lat);
            const lon = parseFloat(response.data[0].lon);
            return `${lat}, ${lon}`;
        }

        console.warn('Gagal mendapatkan koordinat tengah.');
        return null;
    } catch (error) {
        console.error('Error mendapatkan koordinat tengah:', error.message);
        return null;
    }
}

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

        const csvWriter = createCsvWriter({
            path: path.join(__dirname, 'public', 'output.csv'),
            header: [
                { id: 'id', title: 'ID' },
                { id: 'nama_perusahaan', title: 'Nama Perusahaan' },
                { id: 'alamat', title: 'Alamat' },
                { id: 'latlng', title: 'LatLng' },
            ],
        });

        for (const location of locationsWithNullLatLng) {
            try {
                if (location.latlng !== null) {
                    console.warn(`LatLng sudah diisi untuk ID ${location.id}, melewatkan geocoding.`);
                    continue;
                }

                if (!location.nama_perusahaan || !location.alamat) {
                    console.warn(`Nama perusahaan atau alamat kosong untuk ID ${location.id}, melewatkan geocoding.`);
                    continue;
                }

                const latlng = await getLatLng(location.nama_perusahaan, location.alamat);

                if (!latlng) {
                    console.warn(`Gagal mendapatkan latlng dari OpenStreetMap, mencoba alternatif.`);

                    // Mencoba mendapatkan latlng dengan fungsi alternatif
                    const alternativeLatLng = await getAlternativeLatLng(
                        location.nama_perusahaan,
                        location.alamat
                    );

                    if (alternativeLatLng) {
                        const updatedLocation = {
                            ...location,
                            latlng: alternativeLatLng,
                        };

                        const csvData = {
                            id: updatedLocation.id,
                            nama_perusahaan: updatedLocation.nama_perusahaan,
                            alamat: updatedLocation.alamat,
                            latlng: updatedLocation.latlng,
                        };

                        await csvWriter.writeRecords([csvData]);

                        console.log(`LatLng diperbarui (alternatif) untuk ${updatedLocation.nama_perusahaan}, ${updatedLocation.alamat}:`, updatedLocation);
                    } else {
                        console.warn(`Gagal mendapatkan latlng dari alternatif untuk ${location.nama_perusahaan}, ${location.alamat}.`);

                        // Jika alternatif juga gagal, coba metode cadangan
                        const fallbackLatLng = await getFallbackLatLng();

                        if (fallbackLatLng) {
                            const updatedLocation = {
                                ...location,
                                latlng: fallbackLatLng,
                            };

                            const csvData = {
                                id: updatedLocation.id,
                                nama_perusahaan: updatedLocation.nama_perusahaan,
                                alamat: updatedLocation.alamat,
                                latlng: updatedLocation.latlng,
                            };

                            await csvWriter.writeRecords([csvData]);

                            console.log(`LatLng diperbarui (cadangan) untuk ${updatedLocation.nama_perusahaan}, ${updatedLocation.alamat}:`, updatedLocation);
                        } else {
                            console.warn(`Gagal mendapatkan latlng cadangan untuk ${location.nama_perusahaan}, ${location.alamat}.`);
                        }
                    }
                } else {
                    console.log(`LatLng diperbarui untuk ${location.nama_perusahaan}, ${location.alamat}:`, updatedLocation);
                }
            } catch (error) {
                console.error(`Error selama geocoding untuk ${location.nama_perusahaan}, ${location.alamat}:`, error.message);
            }
        }

        res.status(204).json({ message: 'LatLng berhasil diperbarui' });
    } catch (error) {
        console.error('Error di /updateLatLng:', error);
        res.status(500).json({ error: 'Internal Server Error' });
    }
});

// Fungsi untuk memeriksa kesamaan nama perusahaan
function isSameCompanyName(name1, name2) {
    return name1.toLowerCase() === name2.toLowerCase();
}

app.listen(PORT, () => {
    console.log(`Server berjalan di port ${PORT}`);
});
