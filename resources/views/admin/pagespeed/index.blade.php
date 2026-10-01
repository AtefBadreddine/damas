@extends('admin.layouts.app', [
    'app_title' => 'PageSpeed Monitor'
])

@section('main_content')

<?php

$urls = [
    'https://damas.net/',
    'https://damas.net/property-for-sale/oman',
    'https://damas.net/property-for-sale/muscat',
    'https://damas.net/property-for-sale/turkey',
    'https://damas.net/property-for-sale/istanbul',
    'https://damas.net/property-for-sale/muscat/sultan-haitham-city',
    'https://damas.net/blog/how-to-get-turkish-citizenship-through-real-estate'
    
    // throw the remaining magnificent URLs here
];

?>

<style>
    .psi-good {
        background: #dff0d8 !important;
        color: #3c763d;
    }

    .psi-medium {
        background: #fcf8e3 !important;
        color: #8a6d3b;
    }

    .psi-bad {
        background: #f2dede !important;
        color: #a94442;
    }

    .psi-loading {
        opacity: .45;
    }

    #pagespeed-table td {
        vertical-align: middle;
    }
</style>


<div style="margin-bottom: 20px;">
    <button id="connect-pagespeed" class="btn btn-primary">
        Connect API
    </button>

    <span id="pagespeed-progress" style="margin-left: 15px;"></span>
</div>


<table class="table table-bordered table-striped" id="pagespeed-table">

    <thead>
    <tr>
        <th>#</th>
        <th>URL</th>
        <th>Performance</th>
        <th title="ظهور أول محتوى">FCP</th>
        <th title="ظهور أكبر عنصر">LCP</th>
        <th title="سرعة ظهور المحتوى">Speed</th>
        <th title="تحرّك عناصر الصفحة">CLS</th>
        <th title="سرعة الاستجابة للتفاعل">INP</th>
        <th title="مدة تعطّل التفاعل">TBT</th>
        <th title="تجربة الزوار الفعلية خلال 28 يوم الماضية">CrUX</th>
    </tr>
    </thead>

    <tbody>

    <?php foreach ($urls as $i => $url) { ?>

        <tr data-url="<?= $url ?>">

            <td><?= $i + 1 ?></td>

            <td>
                <a href="<?= $url ?>" target="_blank">
                    <?= $url ?>
                </a>
            </td>

            <td class="performance">—</td>
            <td class="fcp">—</td>
            <td class="lcp">—</td>
            <td class="speed-index">—</td>
            <td class="cls">—</td>
            <td class="inp">—</td>
            <td class="tbt">—</td>
            <td class="crux">—</td>

        </tr>

    <?php } ?>

    </tbody>

</table>


<script>

document
    .getElementById('connect-pagespeed')
    .addEventListener('click', async function () {

        var button = this;
        var progress = document.getElementById('pagespeed-progress');
        var rows = document.querySelectorAll('#pagespeed-table tbody tr');

        button.disabled = true;

        for (var i = 0; i < rows.length; i++) {

            var row = rows[i];
            var url = row.getAttribute('data-url');

            progress.textContent =
                'Checking ' + (i + 1) + ' / ' + rows.length;

            row.classList.add('psi-loading');

            try {

                const response = await fetch(
                    '<?= route("admin.pagespeed") ?>'
                    + '?url=' + encodeURIComponent(url)
                );

                const data = await response.json();

                if (!data.success) {
                    throw new Error(data.error);
                }

                metric(
                    row.querySelector('.performance'),
                    data.performance,
                    data.performance >= 90,
                    data.performance >= 50
                );

                metric(
                    row.querySelector('.lcp'),
                    seconds(data.lcp),
                    data.lcp <= 2500,
                    data.lcp <= 4000
                );

                metric(
                    row.querySelector('.cls'),
                    data.cls,
                    data.cls <= 0.1,
                    data.cls <= 0.25
                );

                if (data.inp) {
                    metric(
                        row.querySelector('.inp'),
                        data.inp + ' ms',
                        data.inp <= 200,
                        data.inp <= 500
                    );
                } else {
                    row.querySelector('.inp').textContent = 'N/A';
                }

                metric(
                    row.querySelector('.tbt'),
                    data.tbt + ' ms',
                    data.tbt <= 200,
                    data.tbt <= 600
                );

                metric(
                    row.querySelector('.fcp'),
                    seconds(data.fcp),
                    data.fcp <= 1800,
                    data.fcp <= 3000
                );

                metric(
                    row.querySelector('.speed-index'),
                    seconds(data.speed_index),
                    data.speed_index <= 3400,
                    data.speed_index <= 5800
                );

                row.querySelector('.crux').textContent =
                    data.crux || 'N/A';

            }
            catch (error) {

                row.querySelector('.performance').textContent = 'ERROR';

                console.error(url, error);
            }

            row.classList.remove('psi-loading');
        }

        progress.textContent = 'Done ✓';
        button.disabled = false;
    });


function seconds(ms)
{
    return (ms / 1000).toFixed(1) + ' s';
}


function metric(cell, value, good, medium)
{
    cell.textContent = value;

    cell.classList.remove(
        'psi-good',
        'psi-medium',
        'psi-bad'
    );

    if (good)
        cell.classList.add('psi-good');
    else if (medium)
        cell.classList.add('psi-medium');
    else
        cell.classList.add('psi-bad');
}

</script>

@endsection