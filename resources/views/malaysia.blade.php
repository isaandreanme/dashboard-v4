<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malaysia</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;700&display=swap" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Noto Sans SC';
            src: url('https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@400;700&display=swap');
        }

        body {
            font-family: 'Noto Sans SC', sans-serif;
            font-size: 10px;
            text-transform: uppercase;
            margin: 3px;
            padding: 3px;
        }

        .header-grid {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            align-items: center;
        }

        .logo {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .center-image {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .code-section {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            text-align: right;
            font-size: 10px;
        }

        .code-section p {
            margin: 0px;
        }

        img {
            height: 60px;
            width: auto;
        }

        .container {
            width: 100%;
            margin-top: 3px;
            border: 0.5px solid black;
        }

        .container-table {
            width: 100%;
            margin-top: 3px;
        }

        .container-table td {
            vertical-align: top;
            padding: 3px;
        }

        .container-table .photo {
            width: 45%;
            text-align: center;
        }

        .container-table .biodata {
            width: 55%;
            text-align: left;
        }

        .biodata-table td {
            padding: 3px;
            border: 0.5px solid black;
            vertical-align: top;
            padding-left: 10px;
            padding-right: 10px;
        }

        .biodata-table .label {
            font-weight: bold;
            width: 40%;
        }

        .rounded-lg {
            border-radius: 12px;
        }

        .w-full {
            width: 100%;
        }

        .h-auto {
            height: auto;
        }

        .combined-section-table {
            width: 100%;
            margin-top: 3px;
            border: 0.5px dashed;
        }

        .combined-section-table td {
            vertical-align: top;
            padding: 3px;
            padding-left: 10px;
            padding-right: 10px;

        }

        .combined-section-table .half-width {
            width: 50%;
        }

        h4 {
            text-align: center;
            margin: 3px 0;
            font-size: 10px;
            text-transform: uppercase;
        }

        .text-sm {
            font-size: 10px;
        }

        .text-sm1 {
            font-size: 8px;
        }

        .p-2 {
            padding: 3px;
        }

        .mb-4 {
            margin-bottom: 3px;
        }

        .experience-entry {
            margin: 3px 0;
            padding: 3px;
            border: 0.5px solid black;
            padding-left: 10px;
            padding-right: 10px;

        }

        .avoid-page-break {
            page-break-inside: avoid;
        }

        .declaration {
            text-align: center;
            padding: 1px;
            margin: px 0;
            page-break-inside: avoid;
        }

        .center-align {
            text-align: center;
            /* Center text horizontally */
            vertical-align: middle;
            /* Center text vertically */
        }
    </style>
</head>

<body>
    <!-- Header Section Using Table -->
    <table class="header-table" width="100%" style="border-collapse: collapse;">
        <tr>
            <!-- Left: Logo -->
            <td width="33%" style="text-align: left;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/logo.png'))) }}" alt="Logo" width="100">
            </td>

            <!-- Center: Malaysia PNG -->
            <td width="33%" style="text-align: center;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/malaysia.png'))) }}" alt="Malaysia" width="100">
            </td>

            <!-- Right: Code Section -->
            <td width="33%" style="text-align: right;">
                <div>
                    <p><strong>Code:</strong> {{ $marketing->code_my ?? '-' }}</p>
                    <p><strong>Date:</strong> {{ date('d-m-Y H:i:s') }}</p>
                </div>
            </td>
        </tr>
    </table>

    <hr style="width: 100%; border: 0.5px dashed;">

    <h4 class="text-center mb-4 uppercase">Applicants Information Sheet 申請人資料</h4>

    <!-- Container Section for Photo and Biodata -->
    <div class="combined-section-table w-full avoid-page-break">
        <table class="container-table ">
            <tr>
                <td class="photo">
                    @if ($marketing && $marketing->foto)
                    <img class="rounded-lg w-full h-auto" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $marketing->foto))) }}" alt="Photo">
                    @else
                    <img class="rounded-lg w-full h-auto" src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/user.svg'))) }}" alt="Default Photo">
                    @endif
                </td>
                <td class="biodata">
                    <table class="biodata-table w-full">
                        <tr>
                            <td class="label">Name:</td>
                            <td>{{ $pendaftaran->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Nationality:</td>
                            <td>{{ $marketing->national ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Gender:</td>
                            <td>{{ $marketing->kelamin ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Education:</td>
                            <td>{{ $marketing->lulusan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Religion:</td>
                            <td>{{ $marketing->agama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Ranking by age:</td>
                            <td>{{ $marketing->anakke ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">No. of brothers:</td>
                            <td>{{ $marketing->brother ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">No. of sisters:</td>
                            <td>{{ $marketing->sister ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Age:</td>
                            <td>
                                @if ($pendaftaran && $pendaftaran->tgl_lahir)
                                {{ \Carbon\Carbon::parse($pendaftaran->tgl_lahir)->age }} years old
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Date of Birth:</td>
                            <td>
                                @if ($pendaftaran && $pendaftaran->tgl_lahir)
                                {{ \Carbon\Carbon::parse($pendaftaran->tgl_lahir)->format('d/m/Y') }}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Marital Status:</td>
                            <td>{{ $marketing->status_nikah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Height:</td>
                            <td>{{ $marketing->tinggi_badan ?? '-' }} CM</td>
                        </tr>
                        <tr>
                            <td class="label">Weight:</td>
                            <td>{{ $marketing->berat_badan ?? '-' }} KG</td>
                        </tr>
                        <tr>
                            <td class="label">Son(s) / Age:</td>
                            <td>{{ $marketing->son ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Daughter(s) / Age:</td>
                            <td>{{ $marketing->daughter ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Phone Number:</td>
                            <td>{{ $marketing->nomor_hp ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <br>

    <!-- Section: Overseas Experience, Language Skills and Working Experience -->
    <h4 class="text-center mb-4 uppercase ">Overseas Experience, Language Skills and Working Experience</h4>
    <table class="combined-section-table avoid-page-break">
        <tr>
            <td class="half-width">

                <!-- Language Skills Section -->
                <h4>Language Skills 語言能力</h4>
                <table class="biodata-table w-full">
                    <tr>
                        <th class="text-gray-700 text-sm p-2 uppercase left-align">Language</th>
                        <th class="text-gray-700 text-sm p-2 uppercase">POOR 差</th>
                        <th class="text-gray-700 text-sm p-2 uppercase">FAIR 平</th>
                        <th class="text-gray-700 text-sm p-2 uppercase">GOOD 好</th>
                    </tr>
                    @foreach ([
                    'English 英語' => $marketing->spokenenglish ?? '-',
                    'Cantonese 廣東話' => $marketing->spokencantonese ?? '-',
                    'Mandarin 國語' => $marketing->spokenmandarin ?? '-'
                    ] as $language => $level)
                    <tr>
                        <td class="text-gray-700 text-sm p-2 uppercase">{{ $language }}</td>
                        <td class="text-gray-700 text-sm p-2 uppercase center-align">@if($level == 'POOR') ✓ @endif</td>
                        <td class="text-gray-700 text-sm p-2 uppercase center-align">@if($level == 'FAIR') ✓ @endif</td>
                        <td class="text-gray-700 text-sm p-2 uppercase center-align">@if($level == 'GOOD') ✓ @endif</td>
                    </tr>
                    @endforeach
                </table>
                <!-- Overseas Experience Section -->
                <h4>Overseas Experience 海外工作經驗</h4>
                <table class="biodata-table w-full">
                    @foreach ([
                    'Indonesia' => $marketing->homecountry ?? '-',
                    'Hong Kong' => $marketing->hongkong ?? '-',
                    'Singapore' => $marketing->singapore ?? '-',
                    'Taiwan' => $marketing->taiwan ?? '-',
                    'Malaysia' => $marketing->malaysia ?? '-',
                    'Macau' => $marketing->macau ?? '-',
                    'Middle East' => $marketing->middleeast ?? '-',
                    'Other' => $marketing->other ?? '-'
                    ] as $country => $years)
                    <tr>
                        <td class="text-gray-700 text-sm p-2 uppercase left-align">{{ $country }}</td>
                        <td class="text-gray-700 text-sm p-2 uppercase left-align">{{ $years }} Years</td>
                    </tr>
                    @endforeach
                </table>

            </td>

            <td class="half-width">
                <!-- Working Experience Section -->
                <h4>Working Experience 工作經驗</h4>
                <table class="biodata-table w-full">
                    <tr>
                        <th class="text-gray-700 text-sm p-2 uppercase left-align"></th>
                        <th class="text-gray-700 text-sm p-2 uppercase">YES 是</th>
                        <th class="text-gray-700 text-sm p-2 uppercase">NO 否</th>
                    </tr>
                    @foreach ([
                    'Care of Babies 照顧嬰兒' => $marketing->careofbabies ?? '-',
                    'Care of Toddler 照顧幼兒 (1-3)' => $marketing->careoftoddler ?? '-',
                    'Care of Children 照顧小孩 (4-12)' => $marketing->careofchildren ?? '-',
                    'Care of Elderly 照顧長者' => $marketing->careofelderly ?? '-',
                    'Care of Disabled 照顧傷殘' => $marketing->careofdisabled ?? '-',
                    'Care of Bedridden 照顧卧床人士' => $marketing->careofbedridden ?? '-',
                    'Care of Pet 照顧寵物' => $marketing->careofpet ?? '-',
                    'Household Works 家務' => $marketing->householdworks ?? '-',
                    'Car Washing 洗車' => $marketing->carwashing ?? '-',
                    'Gardening 打理花園' => $marketing->gardening ?? '-',
                    'Cooking 烹飪' => $marketing->cooking ?? '-',
                    'Driving 駕駛' => $marketing->driving ?? '-'
                    ] as $work => $status)
                    <tr>
                        <td class="text-gray-700 text-sm p-2 uppercase">{{ $work }}</td>
                        <td class="text-gray-700 text-sm p-2 uppercase center-align">@if($status == 'YES') ✓ @endif</td>
                        <td class="text-gray-700 text-sm p-2 uppercase center-align">@if($status == 'NO') X @endif</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
    <br>
    <!-- Previous Duties Section -->
    <h4 class="text-center mb-4 uppercaser">Previous Duties 過往工作</h4>
    <table class="combined-section-table w-full avoid-page-break">
        @if ($marketing && isset($marketing['pengalaman']) && is_array($marketing['pengalaman']))
        @foreach ($marketing['pengalaman'] as $experience)
        <tr>
            <td colspan="2">
                <table class="biodata-table w-full">
                    <tr>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">
                            <b>Previous Duties</b>
                        </td>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">
                            <b>: {{ $experience['nomorpengalaman'] ?? '-' }}</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Working Country, From, To -->
        <tr>
            <td class="half-width">
                <table class="biodata-table w-full">
                    <tr>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">Working Country 工作國家</td>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">{{ $experience['negara'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">From:</td>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">{{ $experience['tahunmulai'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">To:</td>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">{{ $experience['tahunselesai'] ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td class="half-width">
                <table class="biodata-table w-full">
                    <tr>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">Reason to Leave 離職原因</td>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">{{ $experience['alasan'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">Salary 工資</td>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">{{ $experience['gaji'] ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">No. of Serve 總服務人數</td>
                        <td class="text-gray-700 text-sm1 p-2 uppercase left-align">{{ $experience['jumlahorang'] ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Baris Skills (Kiri dan Kanan) -->
        <tr>
            <td class="half-width">
                <table class="biodata-table w-full">
                    <tr>
                        <th class="text-gray-700 text-sm1 p-2 uppercase left-align">Skill</th>
                        <th class="text-gray-700 text-sm1 p-2 uppercase center-align">YES 是</th>
                        <th class="text-gray-700 text-sm1 p-2 uppercase center-align">NO 否</th>
                        <th class="text-gray-700 text-sm1 p-2 uppercase center-align">Age 年齡</th>
                    </tr>
                    @foreach([
                    'Care of Babies 照顧嬰兒' => ['answer' => $experience['careofbabies'] ?? '-', 'age' => $experience['usiabayi'] ?? '-'],
                    'Care of Toddler 照顧幼兒 (1-3)' => ['answer' => $experience['careoftoddler'] ?? '-', 'age' => $experience['usiabalita'] ?? '-'],
                    'Care of Children 照顧小孩 (4-12)' => ['answer' => $experience['careofchildren'] ?? '-', 'age' => $experience['usiaanak'] ?? '-'],
                    'Care of Elderly 照顧長者' => ['answer' => $experience['careofelderly'] ?? '-', 'age' => $experience['usialansia'] ?? '-'],
                    'Care of Disabled 照顧傷殘' => ['answer' => $experience['careofdisabled'] ?? '-', 'age' => $experience['usiadisable'] ?? '-'],
                    'Care of Bedridden 照顧卧床人士' => ['answer' => $experience['careofbedridden'] ?? '-', 'age' => $experience['usialumpuh'] ?? '-']
                    ] as $skill => $data)
                    <tr>
                        <td class="text-gray-700 text-sm1 p-2">{{ $skill }}</td>
                        <td class="text-gray-700 text-sm1 p-2 center-align">@if($data['answer'] == 'YES') ✓ @endif</td>
                        <td class="text-gray-700 text-sm1 p-2 center-align">@if($data['answer'] == 'NO') X @endif</td>
                        <td class="text-gray-700 text-sm1 p-2 center-align">{{ $data['age'] }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
            <td class="half-width">
                <table class="biodata-table w-full">
                    <tr>
                        <th class="text-gray-700 text-sm1 p-2 uppercase left-align">Skill</th>
                        <th class="text-gray-700 text-sm1 p-2 uppercase center-align">YES 是</th>
                        <th class="text-gray-700 text-sm1 p-2 uppercase center-align">NO 否</th>
                    </tr>
                    @foreach([
                    'Care of Pet 照顧寵物' => $experience['careofpet'] ?? '-',
                    'Household Works 家務' => $experience['householdworks'] ?? '-',
                    'Car Washing 洗車' => $experience['carwashing'] ?? '-',
                    'Gardening 打理花園' => $experience['gardening'] ?? '-',
                    'Cooking 烹飪' => $experience['cooking'] ?? '-',
                    'Driving 駕駛' => $experience['driving'] ?? '-'
                    ] as $skill => $answer)
                    <tr>
                        <td class="text-gray-700 text-sm1 p-2">{{ $skill }}</td>
                        <td class="text-gray-700 text-sm1 p-2 center center-align">@if($answer == 'YES') ✓ @endif</td>
                        <td class="text-gray-700 text-sm1 p-2 center center-align">@if($answer == 'NO') X @endif</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        @endforeach
        @endif
    </table>
    <br>
    <!-- Other Questions Section -->
    <div class="avoid-page-break">
        <h4 class="text-center mb-4 uppercase">Other Questions 其他問題</h4>
        <table class="combined-section-table w-full avoid-page-break">

            <table class="biodata-table w-full">
                <thead>
                    <tr>
                        <th class="text-gray-700 text-sm p-2 uppercase left-align">Question</th>
                        <th class="text-gray-700 text-sm p-2 uppercase center-align">YES 是</th>
                        <th class="text-gray-700 text-sm p-2 uppercase center-align">NO 否</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ([
                    'Do you eat pork? 你吃豬肉嗎?' => $marketing->babi ?? '-',
                    'Accept Day-off not on Sunday? 接受假日不在星期日?' => $marketing->liburbukanhariminggu ?? '-',
                    'Sharing a room with babies / children / elder? 你願意和小孩/嬰兒/長者同房嗎?' => $marketing->berbagikamar ?? '-',
                    'Are you afraid of dog or cat? 你會害怕狗或貓?' => $marketing->takutanjing ?? '-',
                    'Do you smoke? 你會抽煙嗎?' => $marketing->merokok ?? '-',
                    'Do you drink alcohol? 你會喝酒嗎?' => $marketing->alkohol ?? '-',
                    'Have you any prolonged illnesses / undergone surgery? 你有任何長期的疾病/做過手術嗎?' => $marketing->pernahsakit ?? '-'
                    ] as $question => $answer)
                    <tr>
                        <td class="text-gray-700 text-sm p-2 uppercase left-align">{{ $question }}</td>
                        <td class="text-gray-700 text-sm p-2 uppercase center-align">@if($answer == 'YES') ✓ @endif</td>
                        <td class="text-gray-700 text-sm p-2 uppercase center-align">@if($answer == 'NO') X @endif</td>
                    </tr>
                    @endforeach
                </tbody>
                <td class="text-gray-700 text-sm p-2 uppercase left-align">
                    @if ($marketing && $marketing->ketsakit)
                    If Yes, 如有 : {{ $marketing->ketsakit }}
                    @else
                    -
                    @endif
                </td>
            </table>
    </div>

    <!-- Declaration Section -->
    <div class="declaration">
        <p style="font-size: 7px; margin: 0;">
            Declaration by Applicant <br>
            I agree and will be responsible for any publication of above information. I hereby confirm that all information and answer give to me is to the best of my knowledge. <br>
            “The applicant gives all information with No responsibility holding by our company.” “以上資料由申請者提供, 任何法律責任與本公司無關。”
        </p>
    </div>
    <br>
    <table class="avoid-page-break">
        <td class="half-width">
            <table class="w-full">
                <tr>
                    <td class="text-gray-700 text-sm p-2">
                        @if ($kantor)
                        BRANCH OFFICE: {{ $kantor->nama ?? 'Tidak ditemukan' }}
                        @else
                        BRANCH OFFICE: -
                        @endif
                    </td>
                </tr>
            </table>
        </td>
        <td class="half-width">
            <table class="w-full">
                <tr>
                    <td class="text-gray-700 text-sm p-2">
                        @if ($sales)
                        MARKETING: {{ $sales->nama ?? 'Tidak ditemukan' }}
                        @else
                        MARKETING: -
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </table>
</body>

</html>