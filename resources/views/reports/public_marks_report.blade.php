<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            @page {
                margin: 60px 25px;
            }

            * {
                font-family: sans-serif;
            }

            header {
                position: relative;
                left: 0px;
                right: 0px;
                top: -20;
                font-size: 20px !important;
                text-align: center;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                font-size: 14px !important;
                text-align: center;
                line-height: 35px;
            }

            .markstable {
                width: 100%; 
                border: 2px solid black; 
                border-collapse: collapse;
                margin-bottom: 30px;
            }

            .markstable th {
                border: 2px solid black; 
                padding: 5px;
                text-align: left;
                background-color: #303030;
                color: white;
            }

            .markstable td {
                border: 2px solid black; 
                padding: 5px;
            }
            h2, h3, h4 {
                line-height: 25px;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <h2>Pure Mathematics</h2>
            <h3>Perfomance Report</h3>
            <h4>Exam:&nbsp;&nbsp;&nbsp;{{ substr($test->batch->year, -2) }}-{{ $test->type }}-{{ $test->name }}</h4>
            <table style="width: 100%;">
                <tr>
                    <td><h4>Centre:&nbsp;&nbsp;&nbsp;{{ $test->center->name }}</h4></td>
                    <td style="text-align: right;"><h4>Marks Above:&nbsp;&nbsp;&nbsp;0</h4></td>
                </tr>
            </table>
            <div style="width: 100%; border-top: 3px solid black;"></div>
        </header>

        <footer>
            <div style="width: 100%; border-top: 3px solid black;">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <p>PURE PANEL MARKING SYSTEM</p>
                        </td>
                        <td style="text-align: right;"><p>Copyright © <?php echo date("Y");?></p></td>
                    </tr>
                </table>
                <div style="height: 10px;"></div>
            </div>
        </footer>

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <table class="markstable">
                <tr>
                    <th>No</th>
                    <th>Index No</th>
                    <th>Name</th>
                    <th>Marks</th>
                    <th>Rank</th>
                </tr>
                @php
                    $rank = 0;
                    $lastRank = 0;
                    $lastMark = 0;
                @endphp

                @foreach ($test->marks as $mark)
                @php
                    $rank++;

                    if ($lastMark != $mark->mark) {
                        $lastMark = $mark->mark;
                        $lastRank = $rank;
                    }  
                    
                    if ($mark->mark >= 75) {
                        $color = 'rgba(255, 0, 0, 0.3)';
                    } else if ($mark->mark >= 65) {
                        $color = 'rgba(0, 0, 255, 0.3)';
                    } else {
                        $color = 'rgba(0, 0, 0, 0)';
                    }
                @endphp
                <tr style="background-color: {{ $color }}">
                    <td style="width: 60px;">{{ $rank; }}</td>
                    <td style="width: 90px;">{{ $mark->student_id }}</td>
                    <td>{{ $mark->student_name }}</td>
                    <td style="width: 120px;">{{ $mark->mark }}</td>
                    <td style="width: 80px;">{{ $lastRank }}</td>
                </tr>
                @endforeach
            </table>
        </main>
    </body>
</html>