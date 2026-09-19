<?php $current_locale = LaravelLocalization::getCurrentLocale(); ?>
@if($current_locale == "ar")
    <p>
        السلام عليكم <?= @$inputs["name"]; ?>
    </p>
    <p>
        شكرا على تواصلك وثقتك، سنتواصل معك قريبا.
    </p>

    <p>المعلومات المرسلة</p>
    <table>
        <tr>
            <th>الإسم</th>
            <td><?= @$inputs["name"]; ?></td>
        </tr>
        <tr>
            <th>البريد الإلكتروني</th>
            <td><?= @$inputs["email"]; ?></td>
        </tr>
        <tr>
            <th>الجوال</th>
            <td><?= @$inputs["mobile"]; ?></td>
        </tr>
        <tr>
            <th>الرسالة</th>
            <td><?= @$inputs["message"]; ?></td>
        </tr>
    </table>
@else
    
    <p>
        Hi <?= @$inputs["name"]; ?>
    </p>
    <p>
        Thank you for contacting us. We will contact you soon.
    </p>

    <p>Message information</p>
    <table>
        <tr>
            <th>Name</th>
            <td><?= @$inputs["name"]; ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?= @$inputs["email"]; ?></td>
        </tr>
        <tr>
            <th>Mobile</th>
            <td><?= @$inputs["mobile"]; ?></td>
        </tr>
        <tr>
            <th>Message</th>
            <td><?= @$inputs["message"]; ?></td>
        </tr>
    </table>
@endif