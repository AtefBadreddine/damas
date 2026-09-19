<p>السلام عليكم ورحمة الله</p>
<p>
توصلتم برسالة جديدة في موقع داماس، تفاصيل الرسالة:    
</p>
<table>
    <tr>
        <th>Name:</th>
        <td><?= @$inputs["fullname"]; ?></td>
    </tr>
    <tr>
        <th>Email:</th>
        <td><?= @$inputs["email"]; ?></td>
    </tr>
    <tr>
        <th>Mobile:</th>
        <td><?= @$inputs["mobile"]; ?></td>
    </tr>
    <tr>
        <th>Page:</th>
        <td><?= strtok(@$inputs["page"], '?') ?></td>
    </tr>
    <tr>
        <th>Source:</th>
        <td>
            <?php
                $is_src = false;
                foreach ( Helper::query("ClientSource", "orderBy", ["field" => "src", "value" => "DESC"])->get() as $row ) {
                    if (strpos(strtolower(@$inputs["src"]), strtolower($row->src)) !== false) {
                        $inputs["src"] = $row->code; 
                        $is_src = true;
                        break;
                    }
                }
                if ( $is_src == false ) {
                    //$inputs["src"]="UNKNOWN";
                }
            ?>
			<?= @$inputs["src"]; ?>
        </td>
    </tr>
    <tr>
        <th>Device:</th>
        <td><?= @$inputs["device"]; ?></td>
    </tr>
    <tr>
        <th>Message:</th>
        <td><?= @$inputs["message"]; ?></td>
    </tr>
    <tr>
        <th>Hours:</th>
        <td><?= @$inputs["communication_time"]; ?></td>
    </tr>
    <tr>
        <th>Budget:</th>
        <td><?= @$inputs["budget"]; ?></td>
    </tr>
</table>
