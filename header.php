<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sparrow AppCore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary: #4318FF; --bg: #f4f7fe; --text-main: #2b3674; }
        body { background-color: var(--bg); font-family: 'Segoe UI', sans-serif; color: var(--text-main); }
        .auth-card { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); width: 100%; max-width: 450px; }
        .label-std { font-weight: 600; font-size: 0.85rem; color: #707eae; display: block; margin-bottom: 8px; }
        .label-std i { margin-right: 5px; color: var(--primary); }
        .form-control, .form-select { border-radius: 12px; padding: 12px; border: 1px solid #d1d9e6; background: #f8fafc; transition: 0.3s; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 4px 12px rgba(67, 24, 255, 0.1); }
        .btn-std { background: var(--primary); color: white; border: none; padding: 13px; border-radius: 12px; font-weight: 700; width: 100%; margin-top: 15px; }
        .btn-std:disabled { background-color: var(--primary) !important; opacity: 0.8; color: white !important; }
        .welcome-hero { background: var(--primary); color: white; border-radius: 24px; padding: 60px 40px; }
    </style>
</head>
<body>