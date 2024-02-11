@extends('layouts.front')

@section('title', 'Pengajuan Komunitas')

@section('header')
    <section class="section-pagetop bg">
        <div class="container">
            <h2 class="title-page">Pengajuan Komunitas Baru</h2>
        </div> <!-- container //  -->
    </section>
@endsection

@section('content')
    <section class="section-content my-5">
        <div class="container">
            <div class="row">
                <main class="col-md-12">
                    <div class="card card-success">
                        <div class="card-body">
                            <p>Dengan mendaftarkan UKM/Komunitas ke J.Coffee, Anda akan mendapat keuntungan menggunakan sistem J.Coffee seperti menjual produk, menerima pesanan, hingga mempublikasikan kegiatan komunitas.</p>
                            @include('partials.alerts')
                            @if (!empty($proposal) && !session()->has('success'))
                                @if ($proposal->rejected_at)
                                    <p><strong>Pengajuan Ditolak</strong></p>
                                    <p>{{$proposal->reject_reason}}</p>
                                @elseif($proposal->approved_at)
                                    <p><strong>Selamat!</strong></p>
                                    <p>Pengajuan Anda telah disetujui oleh Admin pada {{$proposal->approved_at}}</p>
                                @else
                                    <p><strong>Anda sudah pernah mengajukan Komunitas pada tanggal {{$proposal->created_at}}.</strong></p>
                                @endif
                                <a href="{{route('user.overview')}}" class="btn btn-md btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                            @else
                            <form action="{{route('user.community.propose.store')}}" class="form" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group col-12">
                                    <label for="name">Nama Komunitas/UKM</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" placeholder="Nama Komunitas/UKM yang akan diajukan" required>
                                </div>
                                <div class="form-row px-2">
                                    <div class="form-group col-6">
                                        <label for="banner_file">Logo / Banner</label>
                                        <input type="file" name="banner_file" id="banner_file" accept="image/*" class="form-control" value="{{old('banner_file')}}" required>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="ktp_file">KTP</label>
                                        <input type="file" name="ktp_file" id="ktp_file" accept="image/*" class="form-control" value="{{old('ktp_file')}}" required>
                                        <small class="form-text text-muted">*KTP yang diunggah yaitu KTP ketua UKM</small>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <label for="description">Deskripsi mengenai Komunitas/UKM</label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Jelaskan tentang UKM, bidang usaha, sosial media, dan kontak yang dapat dihubungi" required>{{old('description')}}</textarea>
                                    <small class="form-text text-muted">Sertakan juga nomor handphone yang dapat dihubungi</small>
                                </div>

                                <button type="submit" class="btn btn-md btn-primary btn-block">Ajukan</button>
                            </form>
                            @endif
                        </div>
                    </div> <!-- card.// -->

                </main> <!-- col.// -->
            </div>

        </div> <!-- container .//  -->
    </section>
@endsection
