@extends('layouts.app')

@section('content')

    <div class="col-lg-12 main-body">
        <div class="row">
            <div class="col-md-9">
                <div class="m-portlet main-body__portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Profile | Activities
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h4 class="mb-4">
                            {{ $profileUser->username }} <small class="m--font-secondary p-2">Since {{ $profileUser->created_at->diffForHumans() }} </small>
                        </h4>
                        <div class="m-list-timeline m-list-timeline__wide">
                            <div class="m-list-timeline__items">
                                @forelse ($activities as $activity)
                                    @if (view()->exists("profiles.activities.{$activity->type}"))
                                        @include ("profiles.activities.{$activity->type}")
                                    @endif
                                @empty
                                    <p class="text-center alert m-alert--default p-5">There is no activity for this user yet.</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="m-pagination-center mt-5 text-center">{{ $activities->links() }}</div>

                    </div><!-- .m-portlet__body -->
                </div><!-- .m-portlet -->
            </div>
            <div class="col-md-3">
                <aside class="sidebar">
                    @can ('admin-only')
                        @include('layouts.admin')
                    @endcan
                </aside>
            </div>
        </div>
    </div>

@endsection
