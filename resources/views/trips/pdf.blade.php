<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* 1. フォントの定義（名前を分けて定義し、ボールドの設定も追加） */
        @font-face {
            font-family: 'jp-gothic';
            src: url('{{ storage_path("fonts/ipaexg.ttf") }}') format('truetype');
            font-style: normal;
            font-weight: normal;
        }

        /* 擬似的に太字としても同じフォントを割り当てる */
        @font-face {
            font-family: 'jp-gothic';
            src: url('{{ storage_path("fonts/ipaexg.ttf") }}') format('truetype');
            font-style: normal;
            font-weight: bold;
        }

        /* 2. 全体スタイル */
        body { 
            font-family: 'jp-gothic', sans-serif; 
            color: #334155; 
            line-height: 1.5;
            margin: 0;
            padding: 10px;
        }

        .header { 
            border-bottom: 2px solid #334155; 
            padding-bottom: 10px; 
            margin-bottom: 20px; 
        }

        .header h1 { 
            font-family: 'jp-gothic', sans-serif;
            font-size: 24px; 
            margin: 0 0 10px 0; 
        }

        /* 中略 */

        .date-header { 
            font-family: 'jp-gothic', sans-serif;
            font-size: 18px; 
            font-weight: bold; 
            background: #f1f5f9; 
            padding: 8px 12px;
            border-left: 4px solid #334155;
            margin-bottom: 15px;
        }

        .itinerary-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .time-col {
            width: 70px;
            /* ...既存のスタイル... */
        }

        .itinerary-table td {
            padding: 10px 5px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        .content-col {
            padding-left: 0 !important; /* 左パディングを強制リセット */
            text-align: left;
            width: auto;
        }

        /* タイトル部分の修正：font-familyを確実に指定し、ボールド処理を明示 */
        .content-col strong {
            font-family: 'jp-gothic', sans-serif;
            font-weight: bold;
            display: block;
            font-size: 16px;
            color: #1e293b;
            margin: 0;      /* 上下左右すべてのマージンを0に */
            padding: 0;     /* パディングも0に */
            text-indent: 0;/* パディングも0にする */
        }

        .content-col small {
            display: block;
            font-size: 12px;
            color: #64748b;
        }

        .cost-col {
            width: 80px;
            text-align: right;
            font-size: 13px;
            color: #475569;
        }

        /* 合計金額用のスタイル */
        .total-section {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 2px solid #334155;
            text-align: right;
        }

        .total-label {
            font-size: 14px;
            color: #64748b;
            font-weight: bold;
        }

        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #1e293b;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $trip->title }}</h1>
        <p>Destination: {{ $trip->destination ?? '未設定' }}</p>
        <p>Period: {{ \Carbon\Carbon::parse($trip->start_date)->format('Y.m.d') }} - {{ \Carbon\Carbon::parse($trip->end_date)->format('Y.m.d') }}</p>
    </div>

    @foreach ($itinerariesByDate as $date => $items)
        <div class="day-section">
            <div class="date-header">
                Day {{ $loop->iteration }} - {{ \Carbon\Carbon::parse($date)->format('M j (D)') }}
            </div>

            <table class="itinerary-table">
                @foreach ($items as $item)
                    <tr>
                        <td class="time-col">{{ $item->time ?? '--:--' }}</td>
                        <td class="content-col"><strong>{{ $item->title }}</strong>@if($item->note)<small>{{ $item->note }}</small>@endif</td>
                        <td class="cost-col">
                            @if($item->cost)
                                ¥{{ number_format($item->cost) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    @endforeach
    @php
        // 全日程のコストを合計する
        $totalCost = 0;
        foreach($itinerariesByDate as $date => $items) {
            $totalCost += $items->sum('cost');
        }
    @endphp

    {{-- 合計金額の表示 --}}
    @if($totalCost > 0)
        <div class="total-section">
            <span class="total-label">Estimated Total Cost:</span>
            <span class="total-amount">¥{{ number_format($totalCost) }}</span>
        </div>
    @endif
</body>
</html>