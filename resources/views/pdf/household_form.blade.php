<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Household PDF</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', sans-serif;
        }

        .container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .text-overlay {
            position: absolute;
            color: #000;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Image 1 -->
        <img src="{{ public_path('images/doc-2.jpg') }}" class="background" alt="background">
        <!-- Location of the affected family -->
        <div class="text-overlay" style="position:absolute;top:103px;left:100px;">{{ $household->region }}</div>
        <div class="text-overlay" style="position:absolute;top:126px;left:100px;">{{ $household->province }}</div>
        <div class="text-overlay" style="position:absolute;top:150px;left:100px;">{{ $household->district }}</div>
        <div class="text-overlay" style="position:absolute;top:103px;left:475px;">{{ $household->municipality }}</div>
        <div class="text-overlay" style="position:absolute;top:126px;left:475px;">{{ $household->barangay }}</div>
        <div class="text-overlay" style="position:absolute;top:149px;left:475px;">{{ $household->evacuation_center }}</div>
        <!-- Head of the family -->
        <div class="text-overlay" style="position:absolute;top:196px;left:108px;">{{ $household->lastname }}</div>
        <div class="text-overlay" style="position:absolute;top:218px;left:108px;">{{ $household->firstname }}</div>
        <div class="text-overlay" style="position:absolute;top:239px;left:108px;">{{ $household->middlename }}</div>
        <div class="text-overlay" style="position:absolute;top:259px;left:108px;">{{ $household->name_ext }}</div>
        <div class="text-overlay" style="position:absolute;top:281px;left:108px;">
            {{ \Carbon\Carbon::parse($household->birthdate)->format('d F Y') }}
        </div>
        <div class="text-overlay" style="position:absolute;top:303px;left:108px;">
            {{ \Carbon\Carbon::parse($household->birthdate)->age }}
        </div>
        <div class="text-overlay" style="position:absolute;top:323px;left:108px;">{{ $household->birthplace }}</div>
        @if($household->sex == 'Male')
        <div class="text-overlay" style="position:absolute;top:338px;left:108px;font-size:20px;">&#10004;</div>
        @else
        <div class="text-overlay" style="position:absolute;top:338px;left:190px;font-size:20px;">&#10004;</div>
        @endif
        <div class="text-overlay" style="position:absolute;top:196px;left:477px;">{{ $household->civil_status }}</div>
        <div class="text-overlay" style="position:absolute;top:218px;left:477px;">{{ $household->mothers_maiden_name }}</div>
        <div class="text-overlay" style="position:absolute;top:238px;left:477px;">{{ $household->religion }}</div>
        <div class="text-overlay" style="position:absolute;top:259px;left:477px;">{{ $household->occupation }}</div>
        <div class="text-overlay" style="position:absolute;top:281px;left:477px;">{{ $household->monthly_family_income }}</div>
        <div class="text-overlay" style="position:absolute;top:302px;left:477px;">{{ $household->id_card_presented }}</div>
        <div class="text-overlay" style="position:absolute;top:323px;left:477px;">{{ $household->id_card_number }}</div>
        <div class="text-overlay" style="position:absolute;top:352px;left:477px;">{{ $household->contact_number_primary }}</div>
        <div class="text-overlay" style="position:absolute;top:352px;left:580px;">{{ $household->contact_number_alternate }}</div>
        <div class="text-overlay" style="position:absolute;top:377px;left:110px;">
            {{ json_decode($household->permanent_address, true)['block'] }}
        </div>
        <div class="text-overlay" style="position:absolute;top:377px;left:190px;">
            {{ json_decode($household->permanent_address, true)['street'] }}
        </div>
        <div class="text-overlay" style="position:absolute;top:377px;left:280px;">
            {{ json_decode($household->permanent_address, true)['subdivision'] }}
        </div>
        <div class="text-overlay" style="position:absolute;top:377px;left:390px;">
            {{ json_decode($household->permanent_address, true)['barangay'] }}
        </div>
        <div class="text-overlay" style="position:absolute;top:377px;left:475px;">
            {{ json_decode($household->permanent_address, true)['city'] }}
        </div>
        <div class="text-overlay" style="position:absolute;top:377px;left:555px;">
            {{ json_decode($household->permanent_address, true)['province'] }}
        </div>
        <div class="text-overlay" style="position:absolute;top:377px;left:659px;">
            {{ json_decode($household->permanent_address, true)['zipcode'] }}
        </div>
        @if($household->{'4ps_beneficiary'})
        <div class="text-overlay" style="position:absolute;top:403px;left:108px;font-size:20px;">&#10004;</div>
        @endif
        @if($household->type_of_ethnicity)
        <div class="text-overlay" style="position:absolute;top:403px;left:243px;font-size:20px;">&#10004;</div>
        @endif
    </div>
</body>

</html>