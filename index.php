<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Biaya & Invoice</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #e2e8f0;
            margin: 0;
            padding: 30px;
        }
        .container {
            background: #fff;
            max-width: 700px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }
        h2, h3 {
            text-align: center;
            color: #2d3748;
        }
        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
            color: #4a5568;
        }
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
        }
        input[type="checkbox"] {
            margin-right: 10px;
        }
        input[type="submit"] {
            background-color: #3182ce;
            color: white;
            padding: 12px;
            margin-top: 25px;
            width: 100%;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2b6cb0;
        }
        .invoice {
            background: #f7fafc;
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
        }
        .invoice p {
            margin: 8px 0;
            color: #2d3748;
        }
        .invoice .total {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px dashed #cbd5e0;
            margin-top: 20px;
            padding-top: 10px;
            color: #1a202c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kalkulator Biaya</h2>
        <form method="post">
            <label for="jarak">Jarak Tempuh (km):</label>
            <input type="number" step="0.1" name="jarak" id="jarak" required>

            <label><input type="checkbox" name="jasa" value="1"> Biaya Jasa Pelatihan (Rp180.000)</label>
            <label><input type="checkbox" name="pasang" value="1"> Biaya Pasang (Rp100.000)</label>

            <input type="submit" value="Hitung Biaya & Cetak Invoice">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $jarak = floatval($_POST["jarak"]);
            $biaya_awal = 40000;
            $biaya_per_km = 3500;
            $jasa = isset($_POST["jasa"]) ? 180000 : 0;
            $pasang = isset($_POST["pasang"]) ? 100000 : 0;

            if ($jarak <= 5) {
                $biaya_jarak = $biaya_awal;
                $tambahan_km = 0;
            } else {
                $tambahan_km = $jarak - 5;
                $biaya_jarak = $biaya_awal + ($tambahan_km * $biaya_per_km);
            }

            $total = $biaya_jarak + $jasa + $pasang;

            echo "<div class='invoice'>";
            echo "<h3>Invoice</h3>";
            echo "<p><strong>Tanggal:</strong> " . date('d/m/Y H:i') . "</p>";
            echo "<p><strong>Jarak Tempuh:</strong> {$jarak} km</p>";
            echo "<p>Biaya 5 km pertama: Rp " . number_format($biaya_awal, 0, ',', '.') . "</p>";
            if ($tambahan_km > 0) {
                echo "<p>Biaya Tambahan (" . number_format($tambahan_km, 1) . " km × Rp " . number_format($biaya_per_km, 0, ',', '.') . "): Rp " . number_format($tambahan_km * $biaya_per_km, 0, ',', '.') . "</p>";
            }
            if ($jasa > 0) {
                echo "<p>Biaya Jasa Pelatihan: Rp " . number_format($jasa, 0, ',', '.') . "</p>";
            }
            if ($pasang > 0) {
                echo "<p>Biaya Pasang: Rp " . number_format($pasang, 0, ',', '.') . "</p>";
            }
            echo "<p class='total'>Total Biaya: Rp " . number_format($total, 0, ',', '.') . "</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
