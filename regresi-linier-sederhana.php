<?php

// inisialisasi variabel
    $X = [];
    $Y = [];
    $Xbar = 0;
    $Ybar = 0;

    $sigmaX = 0;
    $sigmaY = 0;
    
    $X_Xbar = [];
    $Y_Ybar = [];
    
    $X_XbarY_Ybar = [];
    $sigmaX_XbarY_Ybar = 0;

    $X_Xbar2 = [];
    $sigmaX_Xbar2 = 0;

    try {

        // prediksi
        $i = 0;
        foreach ($hasil_arsip as $key => $value) {
            
            $X[$i] = (int)$value['nama_bulan'];
            $Y[$i] = (int)$value['stok'];
    
            $Xbar = $Xbar + $X[$i];
            $Ybar = $Ybar + $Y[$i];
    
            $i++;
        }
        // dapatin nilai sigma/jumlah
        $sigmaX = $Xbar;
        $sigmaY = $Ybar;
    
        // dapatin nilai rata-rata
        $Xbar = $Xbar/count($X);
        $Ybar = $Ybar/count($Y);   
    
        // looping lagi buat dapatin X-Xbar dan Y-Ybar
        $i = 0;
        foreach ($hasil_arsip as $key => $value) {
            // cari x-xbar dan y-ybar
            $X_Xbar[$i] = $X[$i] - $Xbar;
            $Y_Ybar[$i] = $Y[$i] - $Ybar;
    
            // cari (x-xbar)(y-ybar)
            $X_XbarY_Ybar[$i] = $X_Xbar[$i] * $Y_Ybar[$i];
    
            // cari (x-xbar)^2
            $X_Xbar2[$i] = pow($X_Xbar[$i], 2);
            $sigmaX_Xbar2 = $sigmaX_Xbar2 + $X_Xbar2[$i];
    
            // cari nilai sigma (X-Xbar)(Y-Ybar)
            $sigmaX_XbarY_Ybar = $sigmaX_XbarY_Ybar + $X_XbarY_Ybar[$i];
            $i++;
        }
    
        // regresi linier = a + bX;
        $b = $sigmaX_XbarY_Ybar/$sigmaX_Xbar2;
    
        // a = y - bX
        $a = $Ybar - $b*$Xbar;
    
        // hasil prediksi
        $Y = $a + $b*$bulanPrediksi;

    }catch(\DivisionByZeroError $e){

        // jika data belum ada sama sekali
        echo "Data belum ada";
    }

