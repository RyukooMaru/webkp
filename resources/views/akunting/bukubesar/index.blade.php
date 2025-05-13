@extends('layouts.admin')

@section('main-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Buku Besar</h3>
                    <a href="{{ route('akunting.bukubesar.pdf') }}" class="btn btn-danger btn-sm " target="_blank">
                            <i class="fas fa-file-pdf"></i> Print to PDF
                        </a>
                </div>
                <div class="card-body">
                    @if($jurnalEntries->isEmpty() && $totalDebetKeseluruhan == 0 && $totalKreditKeseluruhan == 0)
                        <p class="text-center">Tidak ada data penjurnalan.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>Tanggal</th>
                                        <th>Referensi</th>
                                        <th>No. Rekening</th>
                                        <th>Nama Perkiraan</th>
                                        <th>Debet</th>
                                        <th>Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($jurnalEntries->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data untuk ditampilkan pada halaman ini, namun ada total keseluruhan.</td>
                                        </tr>
                                    @else
                                        @php $no = $jurnalEntries->firstItem(); @endphp
                                        @foreach ($jurnalEntries as $entry)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>
                                                    @if($entry->header)
                                                        {{ \Carbon\Carbon::parse($entry->header->tanggal_buat)->format('d M Y') }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($entry->header)
                                                        {{ $entry->header->no_jurnal }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($entry->perkiraan)
                                                        {{ $entry->perkiraan->cls_kiraid }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($entry->perkiraan)
                                                        {{ $entry->perkiraan->cls_ina }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="text-right">{{ number_format($entry->debet, 2, ',', '.') }}</td>
                                                <td class="text-right">{{ number_format($entry->kredit, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="5" class="text-right">Total Keseluruhan:</th>
                                        <th class="text-right font-weight-bold">{{ number_format($totalDebetKeseluruhan, 2, ',', '.') }}</th>
                                        <th class="text-right font-weight-bold">{{ number_format($totalKreditKeseluruhan, 2, ',', '.') }}</th>
                                    </tr>
                                    <tr>
                                        <th colspan="5" class="text-right">
                                            Selisih:
                                        </th>
                                        <th class="text-right font-weight-bold" colspan="2">
                                            @if ($selisihKeseluruhan == 0)
                                                <span class="badge bg-success px-2 py-1">Balance</span>
                                                <span>( {{ number_format($selisihKeseluruhan, 2, ',', '.') }} )</span>
                                            @elseif ($selisihKeseluruhan > 0)
                                                <span class="text-danger">{{ number_format($selisihKeseluruhan, 2, ',', '.') }}</span>
                                            @else
                                                <span class="text-primary">{{ number_format($selisihKeseluruhan, 2, ',', '.') }}</span>
                                            @endif
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @if($jurnalEntries->hasPages())
                        <div class="mt-3">
                            {{ $jurnalEntries->links() }} {{-- Untuk navigasi paginasi --}}
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
var table = $('#dataTable').DataTable();

});
</script>
@endpush
