{{--@props(['id'=>Str::random(5),'editorheight'=>null])--}}
@props(['placeholder' => 'Search Employee', 'id'])

<div style="position:relative">
    <div class="input-group input-group-solid">
        <span class="input-group-text" id="search">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"/>
                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black"/>
            </svg>
        </span>
        <input wire:model.debounce.500ms="{{$attributes->whereStartsWith('wire:model')->first()}}"  class="form-control" type="text"  placeholder="{{$placeholder}}" aria-label="search" aria-describedby="search"/>
        @if(!empty($itemSearch))
            <button wire:click="$set('{{$attributes->whereStartsWith('wire:model')->first()}}', '')" class="input-group-text btn btn-light" type="button" id="button-addon2"><i class="las la-times"></i></button>
        @endif
    </div>
    <div style="position:absolute; z-index:100; left: 0; right: 0; ">
        @if(strlen($itemSearch)>2)
            @if(count($searchResultItems)>0)
                <ul class="list-group rounded-0">
                    @foreach($searchResultItems as $sri)
                        <li class="list-group-item list-group-item-action">
                            {{--<a href="#" class="d-block pe-auto" style="margin: 0 !important;" wire:click="searchSelectItem({{$sri->id}})">--}}
                            <a href="#" class="d-block pe-auto" style="margin: 0 !important;">
                                {{--@if(!empty($sri->avatar) && (file_exists(public_path('storage/item_image/'.$sri->avatar)) || file_exists(public_path('storage/'.$sri->avatar))))--}}
                                {{--@if(file_exists(public_path('storage/item_image/'.$sri->avatar)))--}}
                                {{--<img class="float-start" src="{{ asset('storage/item_image/'.$sri->item_image) }}" style="object-fit: contain; border: 1px solid #f5f5f5; border-radius: 4px; width: 60px; height: 40px; margin-right: 10px;" />--}}
                                {{--@elseif(file_exists(public_path('storage/'.$sri->item_image)))--}}
                                {{--<img class="float-start" src="{{ asset('storage/'.$sri->item_image) }}" style="object-fit: contain; border: 1px solid #f5f5f5; border-radius: 4px; width: 60px; height: 40px; margin-right: 10px;" />--}}
                                {{--@endif--}}
                                {{--@else--}}
                                {{--<img class="float-start" src="{{ asset('storage/avatar.jpg') }}" style="object-fit: contain; border-radius: 4px; width: 60px; height: 40px; margin-right: 10px;" />--}}
                                {{--@endif--}}
                                <img class="float-start" src="{{ asset('storage/avatar.jpg') }}" style="object-fit: contain; border-radius: 4px; width: 60px; height: 40px; margin-right: 10px;" />
                                <strong>{{$sri->first_name ?? '' }} {{$sri->last_name ?? '' }}</strong>
                                {{--<span class="float-end">{{ $sri->position->pos_name ?? "None" }}</span><br/>--}}
                                <i>{{ $sri->position->pos_name ?? "None" }} </i>&nbsp;&nbsp;
                                <i>{{$sri->office->dept_name ?? 'None'}} </i>
                                {{--<strong>{{$sri->item}}</strong>--}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <ul class="list-group rounded-0">
                    <li class="list-group-item">Found nothing...</li>
                </ul>
            @endif
        @endif
    </div>
</div>
