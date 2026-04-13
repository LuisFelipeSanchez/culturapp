<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificados - {{ $course->title }}</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .page {
            width: 100%;
            height: 100%;
            page-break-after: always;
            position: relative;
            overflow: hidden;
        }
        .page:last-child {
            page-break-after: auto;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            border: 25px solid #3650BB;
            box-sizing: border-box;
        }
        .inner-border {
            position: absolute;
            top: 35px;
            left: 35px;
            width: calc(100% - 70px);
            height: calc(100% - 70px);
            border: 2px solid #0CB29C;
            z-index: -1;
            box-sizing: border-box;
        }
        .content {
            padding: 60px 100px;
            text-align: center;
            position: relative;
            z-index: 10;
        }
        .header {
            margin-bottom: 20px;
        }
        .logo {
            width: 250px;
            object-fit: contain;
        }
        .title {
            color: #3650BB;
            font-size: 50px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .text {
            color: #4B5563;
            font-size: 22px;
            line-height: 1.5;
            margin: 30px 0;
        }
        .name {
            font-size: 38px;
            font-weight: bold;
            color: #1F2937;
            text-transform: uppercase;
            border-bottom: 3px solid #0CB29C;
            display: inline-block;
            padding-bottom: 5px;
            margin: 20px 0 5px 0;
        }
        .doc {
            font-size: 16px;
            color: #6B7280;
            margin-bottom: 20px;
        }
        .course {
            font-size: 32px;
            font-weight: bold;
            color: #0CB29C;
            margin: 20px 0;
        }
        .grade-box {
            margin-top: 10px;
            font-size: 20px;
        }
        .footer {
            margin-top: 40px;
            font-size: 16px;
            color: #6B7280;
        }
        .signature-area {
            margin-top: 60px;
            width: 100%;
            text-align: center;
        }
        .signature {
            display: inline-block;
            width: 300px;
            border-top: 1px solid #9CA3AF;
            padding-top: 10px;
            font-weight: bold;
            color: #4B5563;
        }
    </style>
</head>
<body>
    @foreach($enrollments as $enrollment)
        <div class="page">
            <div class="background"></div>
            <div class="inner-border"></div>
            <div class="content">
                
                <div class="header">
                    <h2 style="color: #3650BB; margin: 0; font-size: 32px; letter-spacing: -1px;">Alcaldía de <span style="color: #0CB29C;">Manizales</span></h2>
                    <h3 style="color: #4B5563; margin: 0; font-size: 20px; font-weight: normal;">Secretaría de Cultura</h3>
                </div>

                <div class="title">Certificado de Aprobación</div>

                <div class="text">
                    La Alcaldía de Manizales y la Secretaría de Cultura certifican que:<br>
                    
                    <div class="name">{{ $enrollment->student->name }}</div><br>
                    <div class="doc">
                        Identificado/a con documento: {{ $enrollment->student->document_number ?? 'N/D' }}
                    </div>
                    
                    El ciudadano {{ $enrollment->student->name }} aprobó el curso<br>
                    <div class="course">{{ $course->title }}</div>
                    
                    <div class="grade-box">
                        @if(isset($enrollment->calculated_average))
                            Calificación Promedio: <strong>{{ number_format($enrollment->calculated_average, 1) }}</strong> &nbsp;|&nbsp; 
                        @endif
                        Intensidad: <strong>{{ $course->hours }} horas</strong>
                    </div>
                </div>

                <div class="footer">
                    Dado en la ciudad de Manizales, a los {{ \Carbon\Carbon::now()->locale('es')->translatedFormat('d \d\e F \d\e Y') }}.
                </div>

                <div class="signature-area">
                    <div class="signature">
                        Secretaría de Cultura<br>
                        Alcaldía de Manizales
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
