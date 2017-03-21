@extends('layouts.app')

@section('content')
<div class="panel panel-default adventure-panel">
    <div class="panel-heading">Oponente.</div>
    <div class="panel-body">
        <div class="alert alert-info" role="alert">{!! $adventureTip !!}</div>

        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">{!! session('error') !!}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Criatura</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($creatures as $creature)
                    <tr>
                        <td>
                            <img src="{{ $creature->image }}" alt="{{ $creature->name }}" data-toggle="popover" data-trigger="hover" data-placement="right" title="<strong>Atributos</strong>" data-content="
                                <table class='table table-condensed'>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{ $user->nickname }}</th>
                                            <th>{{ $creature->name }}</th>
                                        </tr>
                                    </thead>
                                        <tr>
                                            <td><img src='/img/icons/health.png'></td>
                                            <td><div class='text-center'>{{ $user->current_health }}</div></td>
                                            <td><div class='text-center'>{{ $creature->health }}</div></td>
                                        </tr>
                                        <tr>
                                            <td><img src='/img/icons/sword.png'></td>
                                            <td><div class='text-center'>{{ $user->getBonusDamage() }}</div></td>
                                            <td><div class='text-center'>{{ $creature->attack }}</div></td>
                                        </tr>
                                        <tr>
                                            <td><img src='/img/icons/shield.png'></td>
                                            <td><div class='text-center'>{{ $user->melee_defence }}</div></td>
                                            <td><div class='text-center'>{{ $creature->armor }}</div></td>
                                        </tr>
                                        <tr>
                                            <td><img src='/img/icons/magic.png'></td>
                                            <td><div class='text-center'>-</div></td>
                                            <td><div class='text-center'>{{ $creature->magic_resistance }}</div></td>
                                        </tr>
                                    <tbody>
                                    </tbody>
                                </table>">
                        </td>
                        <td>
                            {{ $creature->name }} <span class="label label-default">Lv. {{ $creature->level }}</span>
                        </td>
                        <td>
                            @if ($user->level == $creature->level)
                            <button onClick="setCreature({{ $creature->id }})" class="btn btn-danger" data-toggle="popover" data-trigger="hover" data-placement="left" title="{{ $creature->name }}" data-content="Oponente digno.">{{ trans('buttons.fight') }}</button>
                            @elseif ($user->level < $creature->level)
                                <button onClick="setCreature({{ $creature->id }})" class="btn btn-danger" data-toggle="popover" data-trigger="hover" data-placement="left" title="{{ $creature->name }}" data-content="Level {{ $creature->level }} recomendado.">{{ trans('buttons.fight') }}</button>
                            @else
                                <button onClick="setCreature({{ $creature->id }})" class="btn btn-danger" data-toggle="popover" data-trigger="hover" data-placement="left" title="{{ $creature->name }}" data-content="Você é mais forte que isso.">{{ trans('buttons.fight') }}</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="/battle" method="POST" id="battle-form">
            {{ csrf_field() }}
            <input type="hidden" name="creature_id" />
        </form>
    </div>
</div>
@endsection

@section('scripts')
    @parent
    <script>
        function setCreature(creatureId) {
            document.querySelector('[name=creature_id]').value = creatureId;
            document.querySelector('#battle-form').submit();
        }
        $('[data-toggle="popover"]').popover({html:true});
    </script>
@endsection

@section('styles')
    @parent
    <style>
        .adventure-panel img:hover {
            cursor: url('/img/icons/attack.png'), auto;
        }

        tbody tr {
            height: 60px;
        }
    </style>
@endsection
