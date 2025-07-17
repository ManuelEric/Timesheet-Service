<table>
    <tr>
        <td>Detail List Fee</td>
    </tr>
    <tr></tr>
    <!-- Header -->
    <tr>
        <td rowspan="2" width="5" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold;">#
        </td>
        <td rowspan="2" width="30" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold;">
            Transaksi</td>
        <td rowspan="2" width="20" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold;">Fee
            Gross</td>
        <td rowspan="2" width="20" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold;">Tax
            (2.5%)</td>
        <td rowspan="2" width="20" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold;">Fee
            Nett</td>
        <td rowspan="2" width="20" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold;">
            Rounding</td>
        <td rowspan="2" width="20" align="center" valign="middle" style="border: 1px solid #000; font-weight: bold;">
            Additional / Bonus Fee</td>
        <td colspan="5" align="center" style="border: 1px solid #000; font-weight: bold;">Information</td>
    </tr>
    <tr>
        <td width="35" align="center" style="border: 1px solid #000; font-weight: bold;">Name</td>
        <td width="35" align="center" style="border: 1px solid #000; font-weight: bold;">Account Name</td>
        <td width="20" align="center" style="border: 1px solid #000; font-weight: bold;">Account No</td>
        <td width="22" align="center" style="border: 1px solid #000; font-weight: bold;">Bank</td>
        <td width="10" align="center" style="border: 1px solid #000; font-weight: bold;">Swift Code</td>
    </tr>
    <!-- Header end -->

    <!-- Body -->
    @php
        $subtotal_fee_gross = $subtotal_tax = $subtotal_fee_nett = $subtotal_rounding = $subtotal_additional_bonus = 0;
    @endphp
    @foreach ($activities as $activity)
        @php
            $subtotal_fee_gross += $activity->subtotal_fee_gross;
            $subtotal_tax += $activity->tax;
            $subtotal_fee_nett += $activity->subtotal_fee_nett;
            $subtotal_rounding += $activity->rounding;
            $subtotal_additional_bonus += $activity->subtotal_additional_or_bonus_fee;
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $activity->package_name }}</td>
            <td align="right">{{ $activity->subtotal_fee_gross }}</td>
            <td align="right">{{ $activity->tax }}</td>
            <td align="right">{{ $activity->subtotal_fee_nett }}</td>
            <td align="right">{{ $activity->rounding }}</td>
            <td align="right">{{ $activity->subtotal_additional_or_bonus_fee }}</td>
            <td align="left">{{ $activity->full_name }}</td>
            <td align="left">{{ $activity->account_name }}</td>
            <td align="left">{{ $activity->account_no }}</td>
            <td align="left">{{ $activity->bank_name }}</td>
            <td align="center">{{ $activity->swift_code }}</td>
        </tr>
    @endforeach
    <!-- Body end -->

    <!-- Footer -->
    <tr>
        <td></td>
        <td style="font-weight: bold;">Subtotal</td>
        <td style="font-weight: bold;">{{ $subtotal_fee_gross }}</td>
        <td style="font-weight: bold;">{{ $subtotal_tax }}</td>
        <td style="font-weight: bold;">{{ $subtotal_fee_nett }}</td>
        <td style="font-weight: bold;">{{ $subtotal_rounding }}</td>
        <td style="font-weight: bold;">{{ $subtotal_additional_bonus }}</td>
    </tr>
    <tr>
        <td></td>
        <td style="font-weight: bold;">Total</td>
        <td style="font-weight: bold;">
            {{ $subtotal_fee_nett + $subtotal_additional_bonus }}
        </td>
    </tr>
    <!-- Footer end -->
</table>
