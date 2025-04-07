<div class="text-center mb-3">
    <?php
    $query_string = '';
    if (!empty($_GET)) {
        $params = $_GET;
        unset($params['p']); // Remove page parameter if exists
        $query_string = http_build_query($params) . '&';
    }
    ?>

    <?php if ($p > 1): ?>
        <a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY; ?>" href="<?php echo ADMIN_BASEHREF ?>entries/?<?php echo $query_string; ?>p=1">
            <i class="fa-solid fa-angle-double-left"></i>
        </a>
        <a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY; ?>" href="<?php echo ADMIN_BASEHREF ?>entries/?<?php echo $query_string; ?>p=<?php echo ($p - 1); ?>">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
    <?php endif; ?>

    <?php
    // Pagination logic to show a maximum of 4 buttons with ellipsis
    if ($totalPages <= 4) {
        for ($i = 1; $i <= $totalPages; $i++) {
            echo '<a class="custom-btn ' . ($p == $i ? BTN_SECONDARY : BTN_OUTLINE_SECONDARY) . '" href="' . ADMIN_BASEHREF . 'entries/?' . $query_string . 'p=' . $i . '">' . $i . '</a>';
        }
    } else {
        if ($p > 3) {
            echo '<a class="custom-btn ' . BTN_OUTLINE_SECONDARY . '" href="' . ADMIN_BASEHREF . 'entries/?' . $query_string . 'p=1">1</a>';
            if ($p > 4) {
                echo '<span class="mx-2">...</span>';
            }
        }
        
        for ($i = max(1, $p - 1); $i <= min($totalPages, $p + 1); $i++) {
            echo '<a class="mx-1 custom-btn ' . ($p == $i ? BTN_SECONDARY : BTN_OUTLINE_SECONDARY) . '" href="' . ADMIN_BASEHREF . 'entries/?' . $query_string . 'p=' . $i . '">' . $i . '</a>';
        }
        
        if ($p < $totalPages - 2) {
            if ($p < $totalPages - 3) {
                echo '<span class="mx-2">...</span>';
            }
            echo '<a class="custom-btn ' . BTN_OUTLINE_SECONDARY . '" href="' . ADMIN_BASEHREF . 'entries/?' . $query_string . 'p=' . $totalPages . '">' . $totalPages . '</a>';
        }
    }
    ?>

    <?php if ($p < $totalPages): ?>
        <a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY; ?>" href="<?php echo ADMIN_BASEHREF ?>entries/?<?php echo $query_string; ?>p=<?php echo ($p + 1); ?>">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
        <a class="custom-btn <?php echo BTN_OUTLINE_SECONDARY; ?>" href="<?php echo ADMIN_BASEHREF ?>entries/?<?php echo $query_string; ?>p=<?php echo $totalPages; ?>">
            <i class="fa-solid fa-angle-double-right"></i>
        </a>
    <?php endif; ?>
</div>
