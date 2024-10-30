<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Opnicare System') }}</title>

    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/demo.min.css?1692870487') }} rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .alert-position-top-right {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            width: 300px;
            display: flex;
            flex-direction: column; /* Memungkinkan alert ditumpuk ke bawah */
            gap: 1px; /* Jarak antara alert */
        }

        .btn-gr {
            background-color: #007037;
            color: white;
        }

        .btn-outline-gr {
            --tblr-btn-color: #007037;
            --tblr-btn-bg: transparent;
            --tblr-btn-border-color: #007037;
            --tblr-btn-hover-color: var(--tblr-primary-fg);
            --tblr-btn-hover-border-color: transparent;
            --tblr-btn-hover-bg: #007037;
            --tblr-btn-active-color: var(--tblr-primary-fg);
            --tblr-btn-active-bg: #007037;
            --tblr-btn-disabled-color: #007037;
            --tblr-btn-disabled-border-color: #007037;
        }

        .dtable-container {
            max-width: 100% !important;


            table {
                white-space: nowrap !important;
                width:100%!important;
                border-collapse:collapse!important;
            }
        }


        .navbar-vertical .nav-item .nav-link {
            transition: background 0.2s ease, color 0.2s ease;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
        }

        .navbar-vertical .nav-item .nav-link:hover {
            background-color: #f1f5f9;
            color: #0056b3;
        }

        .navbar-vertical .nav-item .icon {
            color: #0056b3;
            transition: color 0.2s ease;
        }

        .navbar-vertical .nav-item .nav-link-title {
            font-weight: 500;
        }


    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.4.3/css/scroller.dataTables.min.css">


    @yield('styles')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.4.3/js/dataTables.scroller.min.js"></script>

</head>
<style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
        font-feature-settings: "cv03", "cv04", "cv11";
    }

</style>
</head>

<body>
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>
    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                    aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('dist/img/opnicare.png') }}" width="110" height="32" alt="Opni Care" class="navbar-brand-image">
                    </a>
                </h1>
                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">
                        <!-- Menu Item -->
                        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                            <a class="nav-link d-flex align-items-center" href="{{ route('dashboard') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0"/>
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"/>
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"/>
                                </svg>
                                <span class="nav-link-title">Home</span>
                            </a>
                        </li>
        
                        <!-- Dropdown for Data Layanan -->
                        <li class="nav-item dropdown {{ request()->is('layanans/*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#navbar-base" data-bs-toggle="dropdown"
                               data-bs-auto-close="false" role="button" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M14 18h-4a2 2 0 0 1 -2 -2v-8h2v8a2 2 0 0 0 2 2h8a2 2 0 0 1 2 2v8h-2v-8a2 2 0 0 0 -2 -2h-4"/>
                                    <path d="M14 10v-8h-2v8"/>
                                    <path d="M13 10h-3a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h3v-8a2 2 0 0 0 -2 -2"/>
                                </svg>
                                <span class="nav-link-title">Layanan</span>
                            </a>
                                <div class="dropdown-menu show">
                                    <div class="dropdown-menu-columns">
                                            <a class="dropdown-item {{ Route::is('pendaftarans.*') ? 'active' : '' }}" href="{{ route('pendaftarans.index') }}">Pendaftaran Pasien</a>
                                            <a class="dropdown-item {{ Route::is('kamars.*') ? 'active' : '' }}" href="{{ route('kamars.index') }}">Kamar</a>
                                    </div>
                                </div>
                        </li>

                        <!-- Dropdown for Data Layanan -->
                        <li class="nav-item dropdown {{ request()->is('data/*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#navbar-base" data-bs-toggle="dropdown"
                               data-bs-auto-close="false" role="button" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <rect x="4" y="4" width="16" height="16" rx="2" />
                                </svg>
                                <span class="nav-link-title">Data</span>
                            </a>
                                <div class="dropdown-menu show">
                                    <div class="dropdown-menu-columns">
                                            <a class="dropdown-item {{ Route::is('datapolis.*') ? 'active' : '' }}" href="{{ route('datapolis.index') }}">Data Poli</a>
                                    </div>
                                </div>
                        </li>
                        
                        <!-- Dropdown for Data Master -->
                        <li class="nav-item dropdown {{ request()->is('masters/*') ? 'active' : '' }}">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#navbar-base" data-bs-toggle="dropdown"
                               data-bs-auto-close="false" role="button" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                                    <path d="M12 12l8 -4.5"/>
                                    <path d="M12 12l0 9"/>
                                    <path d="M12 12l-8 -4.5"/>
                                    <path d="M16 5.25l-8 4.5"/>
                                </svg>
                                <span class="nav-link-title">Data Master</span>
                            </a>
                                <div class="dropdown-menu show">
                                    <div class="dropdown-menu-columns">
                                            <a class="dropdown-item {{ Route::is('pasiens.*') ? 'active' : '' }}" href="{{ route('pasiens.index') }}">Pasien</a>
                                            <a class="dropdown-item {{ Route::is('polis.*') ? 'active' : '' }}" href="{{ route('polis.index') }}">Poli</a>
                                            <a class="dropdown-item {{ Route::is('kamars.*') ? 'active' : '' }}" href="{{ route('kamars.index') }}">Kamar</a>
                                            <a class="dropdown-item {{ Route::is('dokters.*') ? 'active' : '' }}" href="{{ route('dokters.index') }}">Dokter</a>
                                            <a class="dropdown-item {{ Route::is('obats.*') ? 'active' : '' }}" href="{{ route('obats.index') }}">Obat</a>
                                            <a class="dropdown-item {{ Route::is('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Pengguna</a>
                                        
                                    </div>
                                </div>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        
        <!-- Page content -->
        <div class="page-wrapper">
            <div class="container p-3">
                <div class="navbar-nav d-flex g-5 flex-row justify-content-end ms-auto ">

                    <div class="d-none d-lg-flex">
                        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                                </svg>
                        </a>
                        <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                            data-bs-toggle="tooltip" data-bs-placement="bottom">
                            <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path
                                    d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                                </svg>
                        </a>
                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                                aria-label="Show notifications">
                                <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                                <span class="badge bg-red"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Last updates</h3>
                                    </div>
                                    <div class="list-group list-group-flush list-group-hoverable">
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span
                                                        class="status-dot status-dot-animated bg-red d-block"></span>
                                                </div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 1</a>
                                                    <div class="d-block text-secondary text-truncate mt-n1">
                                                        Change deprecated html tags to text decoration classes (#29604)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                            </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 2</a>
                                                    <div class="d-block text-secondary text-truncate mt-n1">
                                                        justify-content:between ⇒ justify-content:space-between (#29734)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions show">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-yellow"
                                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                            </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span class="status-dot d-block"></span></div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 3</a>
                                                    <div class="d-block text-secondary text-truncate mt-n1">
                                                        Update change-version.js (#29736)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                            </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto"><span
                                                        class="status-dot status-dot-animated bg-green d-block"></span>
                                                </div>
                                                <div class="col text-truncate">
                                                    <a href="#" class="text-body d-block">Example 4</a>
                                                    <div class="d-block text-secondary text-truncate mt-n1">
                                                        Regenerate package-lock.json (#29730)
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="#" class="list-group-item-actions">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon text-muted"
                                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                                            </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="nav-item dropdown d-none d-lg-flex">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                style="background-image: url('{{ asset('dist/img/rohman.png') }}')"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>Nur Rohman</div>
                                <div class="mt-1 small text-secondary">Direktur</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <a href="#" class="dropdown-item">Status</a>
                            <a href="./profile.html" class="dropdown-item">Profile</a>
                            <a href="#" class="dropdown-item">Feedback</a>
                            <div class="dropdown-divider"></div>
                            <a href="./settings.html" class="dropdown-item">Settings</a>
                            <a href="./sign-in.html" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>

