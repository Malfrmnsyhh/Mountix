@extends('layouts.app')

@section('title', 'Beranda - Mountix')

@section('content')
  <!-- PHASE 2: HERO SECTION -->
  <x-hero />

  <!-- PHASE 3: GUNUNG POPULER SECTION -->
  <x-gunung-populer :mountains="$popularMountains" />

  <!-- PHASE 7: ALUR BOOKING SECTION -->
  <x-alur-booking />

  <!-- PHASE 4: TENTANG KAMI SECTION -->
  <x-tentang-kami />

  <!-- PHASE 5: FITUR UTAMA SECTION -->
  <x-fitur-utama />
@endsection
