<div style="margin:0;padding:0;background-color:#eaeaef;height:100%">
    <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden">
        {{ $payer }} pagou você.
    </div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#eaeaef;overflow-x:hidden">
        <tbody>
        <tr>
            <td align="left">
                <table align="center" border="0" cellpadding="0" cellspacing="0"
                       style="border-collapse:collapse;overflow-x:hidden;font-family:'proxima-nova',sans-serif;width:95%;max-width:600px">
                    <tbody>
                    <tr>
                        <td align="left">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" style="overflow-x:hidden">
                                <tbody>
                                <tr>
                                    <td align="center"
                                        style="padding:20px 20px 20px 20px;font-family:'proxima-nova',sans-serif">
                                        <p>Laravel Bank</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" bgcolor="#ffffff"
                                        style="padding:20px 40px 0px 40px;font-family:'proxima-nova',sans-serif;border-top-left-radius:10px;border-top-right-radius:10px">
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" bgcolor="#ffffff"
                                        style="padding:20px 40px 0px 40px;font-family:'proxima-nova',sans-serif">
                                        <table align="left" border="0" cellpadding="0" cellspacing="0"
                                               style="background-color:#ffffff;overflow-x:hidden;padding:0px">
                                            <tbody>
                                            <tr>

                                                <td style="vertical-align:center"><h1
                                                        style="color:#0d0d0d;margin:0;font-size:22px;line-height:150%">
                                                        Pagamento Recebido</h1></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff" style="margin:0px;padding:20px 40px 30px 40px">
                                        <table style="width:100%">
                                            <tbody>
                                            <tr>
                                                <td style="background:none;border-top:solid 1px #eaeaef;border-left:none;border-right:none;border-bottom:none;border-collapse:collapse;border-spacing:0;width:100%;margin:0px 0px 0px 0px">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>


                                <tr>
                                    <td bgcolor="#ffffff"
                                        style="padding:20px 40px 0px 40px;margin:0px;font-family:'proxima-nova',sans-serif">
                                        <div
                                            style="margin-left:auto;margin-right:auto;width:100px;height:100px;background:#e0e0e0 url('https://ci3.googleusercontent.com/meips/ADKq_NbcS2Eqnjs4-Rlh3jMlpB7iMlB3U0C6R3u2NqhVBDpjM5KuQ0ZXk2jdSiQmH7rxkeJyqFVquar6JHz3ckX_s4mZZg=s0-d-e1-ft#http://www.picpay.com/img/default_avatar.png') no-repeat center;background-size:cover;border-radius:100px"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" bgcolor="#ffffff"
                                        style="padding:20px 40px 0px 40px;font-family:'proxima-nova',sans-serif">
                                        <p style="padding:0px;color:#5d666f;margin:0;font-size:16px;line-height:150%;font-weight:bold;text-align:center">
                                            <span style="color:#11c76f">{{$payer}}</span> pagou você
                                        </p>
                                        <p style="padding:0px;color:#bfc6ce;margin:0;font-size:14px;line-height:150%;text-align:center">
                                            Transação: {{ $transaction_id }} | {{ $transaction_date }}
                                        </p>
                                        <p style="padding:20px 0px 0px 0px;color:#5d666f;margin:0;font-size:16px;line-height:150%;font-weight:regular;font-style:italic;text-align:center">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff" style="margin:0px;padding:20px 40px 0px 40px">
                                        <table style="width:100%">
                                            <tbody>
                                            <tr>
                                                <td style="background:none;border-top:solid 1px #eaeaef;border-left:none;border-right:none;border-bottom:none;border-collapse:collapse;border-spacing:0;width:100%;margin:0px 0px 0px 0px">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" bgcolor="#ffffff"
                                        style="padding:20px 40px 40px 40px;font-family:'proxima-nova',sans-serif">
                                        <table border="0" cellpadding="0" cellspacing="0"
                                               style="width:100%;background-color:#ffffff;overflow-x:hidden;padding:0px">
                                            <tbody>
                                            <tr>
                                                <td align="left"><p
                                                        style="padding:5px;color:#5d666f;margin:0;font-size:16px;line-height:150%;font-weight:bold;text-align:left">
                                                        Valor recebido
                                                    </p></td>
                                                <td align="right"><p
                                                        style="padding:5px;color:#5d666f;margin:0;font-size:16px;line-height:150%;font-weight:bold;text-align:right">
                                                        R$ {{ $value }}
                                                    </p></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td bgcolor="#ffffff" style="margin:0px;padding:0px 0px 0px 0px">
                                        <table style="width:100%">
                                            <tbody>
                                            <tr>
                                                <td style="background:none;border-top:solid 1px #eaeaef;border-left:none;border-right:none;border-bottom:none;border-collapse:collapse;border-spacing:0;width:100%;margin:0px 0px 0px 0px">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </td>
        </tr>
        </tbody>
    </table>
</div>
