@extends('administrator.layouts.main')

@section('content')
    @push('section_header')
        <h1>Settings</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('admin.settings') }}">Settings</a></div>
            <div class="breadcrumb-item">Frontpage</div>
        </div>
    @endpush
    @push('section_title')
        Setting
    @endpush
    <div class="row">
        @if (isallowed('settings', 'frontpage_general'))
            <div class="col-lg-6 col-12">
                <div class="card card-large-icons">
                    <div class="card-icon bg-main-background-color text-white">
                        <i class="fas fa-cog"></i>
                    </div>
                    <div class="card-body">
                        <h4>General</h4>
                        <p>General Frontpage.</p>
                        <a href="{{ route('admin.settings.frontpage.general') }}" class="card-cta">Change Setting <i
                                class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        @endif
        @if (isallowed('settings', 'frontpage_footer'))
            <div class="col-lg-6 col-12">
                <div class="card card-large-icons">
                    <div class="card-icon bg-main-background-color text-white">
                        <i class="fas fa-window-minimize"></i>
                    </div>
                    <div class="card-body">
                        <h4>Footer</h4>
                        <p>Footer Frontpage.</p>
                        <a href="{{ route('admin.settings.frontpage.footer') }}" class="card-cta">Change Setting <i
                                class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        @endif
        @if (isallowed('settings', 'frontpage_homepage'))
            <div class="col-lg-6 col-12">
                <div class="card card-large-icons">
                    <div class="card-icon bg-main-background-color text-white">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div class="card-body">
                        <h4>Homepage</h4>
                        <p>Homepage Adminsitrator.</p>
                        <a href="{{ route('admin.settings.frontpage.homepage') }}" class="card-cta">Change Setting <i
                                class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
