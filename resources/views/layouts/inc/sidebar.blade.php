<div class="sidebar-wrapper sidebar-theme">
    <nav id="sidebar">
        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu">
                <a href="{{ route('dashboard') }}" data-active="false" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>

            <li class="menu">
                @if(Auth::check() && Auth::user()->level == 'Admin')
                <a href="#datatables" data-active="false" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                            <polyline points="2 17 12 22 22 17"></polyline>
                            <polyline points="2 12 12 17 22 12"></polyline>
                        </svg>
                        <span>Master Data</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="datatables" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('kabupaten.index') }}">Kabupaten</a>
                    </li>
                    <li>
                        <a href="{{ route('kecamatan.index') }}">kecamatan</a>
                    </li>
                    <li>
                        <a href="{{ route('desa.index') }}">Desa</a>
                    </li>
                    <li>
                        <a href="{{ route('resort.index') }}">Resort</a>
                    </li>
                </ul>
                @endif
            </li>

            <li class="menu">
                @if(Auth::check() && Auth::user()->level == 'Admin')
                <a href="{{ route('user.index') }}" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-users">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Users</span>
                    </div>
                </a>
                @endif
            </li>

            <li class="menu">
                <a href="#pages" data-active="false" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-clipboard">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                        <span>TAHUNAN</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="pages" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('desaintapak.index') }}"> Desain Tapak Pemanfaatan Jasa Lingkkungan
                            Wisata ALam </a>
                    </li>
                    <li>
                        <a href="{{  route('kemitraankonservasi.index')  }}"> Kemitraan Konservasi</a>
                    </li>
                    <li>
                        <a href="{{  route('perencanaanpemulihan.index')  }}"> Perencanaan Pemulihan</a>
                    </li>
                    <li>
                        <a href="{{  route('rencanarealisasi.index')  }}">Rencana dan Realisasi </a>
                    </li>
                    <li>
                        <a href="{{  route('daerahpenyangga.index')  }}">Daerah Penyangga </a>
                    </li>
                    <li>
                        <a href="{{  route('desabinaans.index')  }}">Desa Binaan </a>
                    </li>
                    <li>
                        <a href="{{  route('zonablok.index')  }}">Zona dan Blok Tradisional</a>
                    </li>
                    <li>
                        <a href="{{  route('pemanfaatanzona.index')  }}">Pemanfaatan Zona dan Blok Tradisional
                            Kawasan Konservasi</a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#app" data-active="false" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-clipboard">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                        <span>SEMESTER</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="app" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('perencanaanpkk.index') }}">Perencanaan
                            Pengelolahaan Kawasan Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kawasankonservasi.index') }}">Cagar Biosfer
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('penataanbatas.index') }}">Penataan Batas
                            Kawasan Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('rekontruksibatas.index') }}">Rekontruksi Batas
                            Kawasan Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('saranapengamatan.index') }}">Sarana Pengamatan
                            Hutan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pemeliharaanbatas.index') }}">Pemeliharaan Batas
                            Kawasan Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('peralatantangan.index') }}">Peralatan Tangan
                            Pengendalihan Kebakaran Hutan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('peralatantransportasi.index') }}">Peralatan
                            Transportasi Pengenalan Kebakaran Hutan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('peralatanmesin.index') }}">Peralatan Mesin
                            Pompa dan Kelengkapannya untuk Kebutuhan Pengendalian Kebakaran Hutan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('penangananjenis.index') }}">Penanganan Jenis
                            Asing Invasif (IAS) di Kawasan Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('hasilevaluasi.index') }}">Hasil Evaluasi
                            Kesusaian Fungsi Kawasan Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('perubahanfungsikk.index') }}">Perubahan Fungsi
                            dan Perubahan Kawasan Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('ekosistem.index') }}">Ekosistem Kawasan
                            Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('zonasi.index') }}">Penataan Kawasan Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kphk.index') }}"> Penetapan Kesatuan
                            Pengelolaan Hutan Konservasi (KPHK) Taman Nasional dan Non Taman Nasional
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kerjasama.index') }}"> Kerjasama
                            Penyelenggaraan KSA dan KPA
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pameran.index') }}"> Promosi dan
                            Publikasi Jasa Lingkungan Kawasan Konservasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pegawaipendidikan.index') }}"> Sebaran PNS/CPNS Menurut Tingkat
                            Pendidikan dan Jenis Kelamin </a>
                    </li>
                    <li>
                        <a href="{{ route('pegawaigolongan.index') }}"> Sebaran PNS/CPNS
                            Menurut Golongan dan Jenis Kelamin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fungsional.index') }}">Sebaran Pejabat
                            Fungsional Tertentu Menurut Fungsi dan Jenjang Jabatan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fungsionalsex.index') }}">Sebaran Pejabat
                            Fungsional Tertentu Menurut Fungsi dan Jenis Kelamin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('jabatansex.index') }}">Sebaran PNS/CPNS
                            Menurut Jabatan dan Jenis Kelamin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fungsionalpendidikan.index') }}">Fungsional Pendidikan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('honorer.index') }}">Sebaran Pegawai
                            Tidak Tetap Menurut Tingkat Pendidikan dan Jenis Kelamin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bmn.index') }}">Rincian Barang
                            Milik Negara (Gabungan Intrakomptabel dan Ekstrakomptabel)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kerjasamateknis.index') }}">Kerjasama Teknis Bidang KSDAE
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu">
                <a href="#forms" data-active="false" data-toggle="collapse" aria-expanded="false"
                    class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-clipboard">
                            <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                            <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                        </svg>
                        <span>TRIWULAN</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="forms" data-parent="#accordionExample">
                    <li>
                        <a href="{{ route('pembinaanusaha.index') }}">Pembinaan Usaha Ekonomi Produktif pada
                            Daerah Penyangga Kawasan Konservasi</a>
                    </li>
                    <li>
                        <a href="{{ route('permasalahankawasan.index') }}">Permasalahan Kawasan Konservasi</a>
                    </li>
                    <li>
                        <a href="{{ route('penanganan_perkara.index') }}">Penanganan Perkara Tindak Pidana</a>
                    </li>
                    <li>
                        <a href="{{  route('tenagapengamansatker.index')  }}">Tenaga Pengamanan Hutan Per Satuan
                            Kerja</a>
                    </li>
                    <li>
                        <a href="{{ route('tenaga_pengamanan_hutan.index') }}">Tenaga Pengamanan Hutan pada
                            Kawasan Konservasi</a>
                    </li>
                    <li>
                        <a href="{{  route('tenagakarhut.index')  }}">Tenaga Pengendalian Kebakaran Hutan</a>
                    </li>
                    <li>
                        <a href="{{  route('lkkhusus.index')  }}">Lembaga Konservasi Khusus</a>
                    </li>
                    <li>
                        <a href="{{  route('penetapankk.index')  }}">Kawasan Konservasi</a>
                    </li>
                    <li>
                        <a href="{{  route('potensiodtwa.index')  }}">Potensi Wisata Alam di Kawasan
                            Konservasi</a>
                    </li>
                    <li>
                        <a href="{{  route('iupjswa.index')  }}">Pengusahaan Pemanfaatan Jasa Lingkungan Wisata
                            Alam</a>
                    </li>
                    <li>
                        <a href="{{  route('potensiair.index')  }}">Potensi Pemanfaatan Air di Kawasan
                            Konservasi</a>
                    </li>
                    <li>
                        <a href="{{  route('potensikarbon.index')  }}">Potensi Pemanfaatan Karbon di Kawasan
                            Konservasi</a>
                    </li>
                    <li>
                        <a href="{{  route('pemanfaatanair.index')  }}">Pemanfaatan Massa Air di Kawasan
                            Konservasi</a>
                    </li>
                    <li>
                        <a href="{{  route('jasling.index')  }}"> Perizinan Pemanfaatan Jasa Lingkungan pada
                            Kawasan Konservasi</a>
                    </li>
                </ul>
            </li>

            {{-- <li class="menu">
                <a href="#elements" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-zap">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                        <span>Elements</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="submenu list-unstyled collapse show" id="elements" data-parent="#accordionExample" style="">
                    <li>
                        <a href="{{ route('pengambilanhasilhutan.index') }}"> Pengambilan Hasil Hutan </a>
                    </li>
                    <li>
                        <a href="{{ route('penebanganliar.index') }}"> Penebangan Liar </a>
                    </li>
                    <li>
                        <a href="{{ route('perburuanliar.index') }}"> Perburuan Liar </a>
                    </li>
                    <li>
                        <a href="{{ route('tumbuhan.index') }}"> Perjumpaan Flora </a>
                    </li>
                    <li>
                        <a href="{{ route('hewan.index') }}"> Perjumpaan Fauna </a>
                    </li>
            </li> --}}
        </ul>
        </li>
        </ul>


    </nav>
</div>