<?php

function hariIni($time = "D")
{
  $hari = date($time);

  switch ($hari) {
    case 'Sun':
      $hariIni = "Minggu";
      break;

    case 'Mon':
      $hariIni = "Senin";
      break;

    case 'Tue':
      $hariIni = "Selasa";
      break;

    case 'Wed':
      $hariIni = "Rabu";
      break;

    case 'Thu':
      $hariIni = "Kamis";
      break;

    case 'Fri':
      $hariIni = "Jum'at";
      break;

    case 'Sat':
      $hariIni = "Sabtu";
      break;

    default:
      $hariIni = "Tidak diketahui";
      break;
  }

  return $hariIni;
}

function bulanIni($time = "M")
{
  $bulan = date($time);

  switch ($bulan) {
    case 'Jan':
      $bulanIni = "Januari";
      break;

    case 'Feb':
      $bulanIni = "Februari";
      break;

    case 'Mar':
      $bulanIni = "Maret";
      break;

    case 'Apr':
      $bulanIni = "April";
      break;

    case 'mei':
      $bulanIni = "Mei";
      break;

    case 'Jun':
      $bulanIni = "Juni";
      break;

    case 'Jul':
      $bulanIni = "Juli";
      break;

    case 'Aug':
      $bulanIni = "Agustus";
      break;

    case 'Sep':
      $bulanIni = "September";
      break;

    case 'Oct':
      $bulanIni = "Oktober";
      break;

    case 'Nov':
      $bulanIni = "November";
      break;

    case 'Dec':
      $bulanIni = "December";
      break;

    default:
      $bulanIni = "Tidak diketahui";
      break;
  }
  return $bulanIni;
}
