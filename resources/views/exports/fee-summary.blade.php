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
        <td rowspan="2" width="20" align="center" valign="middle"
            style="border: 1px solid #000; font-weight: bold;">Fee
            Gross</td>
        <td rowspan="2" width="20" align="center" valign="middle"
            style="border: 1px solid #000; font-weight: bold;">Tax
            (2.5%)</td>
        <td rowspan="2" width="20" align="center" valign="middle"
            style="border: 1px solid #000; font-weight: bold;">Fee
            Nett</td>
        <td rowspan="2" width="20" align="center" valign="middle"
            style="border: 1px solid #000; font-weight: bold;">
            Rounding</td>
        <td colspan="5" align="center" style="border: 1px solid #000; font-weight: bold;">Information</td>
    </tr>
    <tr>
        <td width="25" align="center" style="border: 1px solid #000; font-weight: bold;">Name</td>
        <td width="25" align="center" style="border: 1px solid #000; font-weight: bold;">Account Name</td>
        <td width="10" align="center" style="border: 1px solid #000; font-weight: bold;">Account No</td>
        <td width="10" align="center" style="border: 1px solid #000; font-weight: bold;">Bank</td>
        <td width="5" align="center" style="border: 1px solid #000; font-weight: bold;">Swift Code</td>
    </tr>
    <!-- Header end -->

    <!-- Body -->
    @php
        $subtotal_fee_gross = $subtotal_tax = $subtotal_fee_nett = $subtotal_rounding = $subtotal_additional_bonus = 0;
    @endphp
    @foreach ($activities as $activity)
        @php
            $fee_gross = $activity->subtotal_fee_gross + $activity->subtotal_additional_or_bonus_fee;
            $tax = 0.025 * $fee_gross;
            $fee_nett = $fee_gross - $tax;

            $subtotal_fee_gross += $fee_gross;
            $subtotal_tax += $tax;
            $subtotal_fee_nett += $fee_nett;
            $subtotal_rounding += roundCustom($fee_nett);
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $activity->package_name }} Fee</td>
            <td align="right">{{ formatToRupiah($fee_gross) }}</td>
            <td align="right">{{ formatToRupiah($tax) }}</td>
            <td align="right">{{ formatToRupiah($fee_nett) }}</td>
            <td align="right">{{ formatToRupiah(roundCustom($fee_nett)) }}</td>
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
        <td style="font-weight: bold;">{{ formatToRupiah($subtotal_fee_gross) }}</td>
        <td style="font-weight: bold;">{{ formatToRupiah($subtotal_tax) }}</td>
        <td style="font-weight: bold;">{{ formatToRupiah($subtotal_fee_nett) }}</td>
        <td style="font-weight: bold;">{{ formatToRupiah($subtotal_rounding) }}</td>
    </tr>
    <!-- Footer end -->
</table>
