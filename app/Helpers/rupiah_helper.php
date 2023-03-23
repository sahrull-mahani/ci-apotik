<?php
function rupiah($angka)
{
  $hasil_rupiah = number_format($angka, 0, ',', '.');
  return $hasil_rupiah;
}

function rupiahRp($angka)
{
  $hasil = "Rp. " . number_format($angka, 0, '', '.');
  return $hasil;
}
