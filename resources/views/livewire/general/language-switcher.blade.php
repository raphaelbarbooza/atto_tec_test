<div id="language-switcher">

    <div id="language-loading-overlay" wire:loading>

    </div>

    <div class="dropdown">
        <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
            <div class="flag-icon">
                <img src="{{\Illuminate\Support\Facades\Vite::asset('resources\images\icons\\'.config('main.localization.available.'.$currentLocale.'.flag_icon'))}}" />
            </div>
            <div class="text-muted ms-2">
                {{config('main.localization.available.'.$currentLocale.'.description')}}
            </div>
        </button>
        <ul class="dropdown-menu">
            @foreach(config('main.localization.available') as $locale => $info)
                @if($locale != $currentLocale)
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#" wire:click.prevent="changeLocale('{{$locale}}')">
                            <div class="flag-icon">
                                <img src="{{\Illuminate\Support\Facades\Vite::asset('resources\images\icons\\'.$info['flag_icon'])}}" />
                            </div>
                            <div class="text-muted ms-2">
                                {{$info['description']}}
                            </div>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

</div>
