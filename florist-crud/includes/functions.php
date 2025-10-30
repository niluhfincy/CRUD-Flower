<?php
function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $key => $value) {
            $input[$key] = sanitize($value);
        }
    } else {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    return $input;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function formatRupiah($price) {
    return "Rp " . number_format($price, 0, ',', '.');
}

function paginate($total_records, $per_page = 6, $page = 1) {
    $total_pages = ceil($total_records / $per_page);
    $page = max(1, min($page, $total_pages));
    $offset = ($page - 1) * $per_page;
    
    return [
        'total_pages' => $total_pages,
        'current_page' => $page,
        'offset' => $offset,
        'per_page' => $per_page
    ];
}
?>