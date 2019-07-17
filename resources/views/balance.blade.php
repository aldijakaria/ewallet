@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                  <table class="table table-bordered">
                    <thead>
                      <th>Tanggal</th>
                      <th>Email</th>
                      <th>Debet</th>
                      <th>Kredit</th>
                      <th>Saldo</th>
                    </thead>
                    <tbody>
                      @php
                        $saldo=$user->saldo;
                      @endphp
                      @foreach ($balance as $key => $value)
                        <tr>
                          <td>{{ $value->created_at }}</td>
                          @if ($value->penerima_id==$user->id)
                            @php
                              $saldo+=$value->saldo;
                            @endphp
                                <td>{{ $value->pengirim->email }}</td>
                                <td>{{ $value->saldo }}</td>
                                <td>0</td>
                                <td>{{ $saldo }}</td>
                          @else
                            @php
                              $saldo-=$value->saldo;
                            @endphp
                                <td>{{ $value->penerima->email }}</td>
                                <td>0</td>
                                <td>{{ $value->saldo }}</td>
                                <td>{{ $saldo }}</td>

                          @endif

                        </tr>
                      @endforeach
                    </tbody>

                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
