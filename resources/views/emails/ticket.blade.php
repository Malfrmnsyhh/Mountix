<!DOCTYPE html>
<html>

<head>
  <title>E-Ticket Pendakian Mountix</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
  <h2>Halo, {{ $booking->user->name }}!</h2>
  <p>Pembayaran Anda untuk booking <strong>{{ $booking->kode_booking }}</strong> telah diverifikasi.</p>
  <p>Berikut adalah rincian E-Ticket pendakian Anda untuk Jalur <strong>{{ $booking->jalur->nama_jalur }}</strong>:</p>

  <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; max-width: 600px;">
    <thead>
      <tr style="background-color: #f4f4f4;">
        <th>Nama Pendaki</th>
        <th>Kode Tiket (QR)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tickets as $ticket)
        <tr>
          <td>{{ $ticket->nama_lengkap }}</td>
          <td>{{ $ticket->qr_code }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <p>Silakan download PDF E-Ticket Anda melalui dashboard aplikasi dan tunjukkan kepada petugas di pos pendakian. Semoga
    pendakian Anda menyenangkan dan selalu jaga kelestarian alam!</p>
</body>

</html>