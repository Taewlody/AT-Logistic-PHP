<!-- <nav aria-label="Page navigation mt-5">
    <ul class="pagination">
        <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?pages=1"; } ?>">«</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?pages=" . $prev; } ?>">‹</a>
        </li>
        <?php
        for($i = 1; $i <= $totoalPages; $i++ ):
        ?>
        <li class="page-item <?php if($page == $i) {echo 'active'; } ?>">
            <a class="page-link" href="' . $url. '?pages=<?= $i; ?>"> <?= $i; ?> </a>
        </li>
        <?php endfor; ?>
        <li class="page-item">
            <a class="page-link" href="<?php if($page >= $totoalPages){ echo '#'; } else {echo "?pages=". $next; } ?>">›</a>
        </li>
        <li class="page-item <?php if($page >= $totoalPages) { echo 'disabled'; } ?>">
            <a class="page-link" href="<?php if($page >= $totoalPages){ echo '#'; } else {echo "?pages=". $totoalPages; } ?>">»</a>
        </li>
    </ul>
</nav> -->


<?php
function pagination($page, $num_page, $url)
{
  $max_pages  = 15; // Set a start and end point for page links
  $start      = $page - 5;
  $end        = $page + 5;

  if($start < 1) $start = 2;
  if($end > $num_page) $end = $num_page -1;

  $prevpage   = $page - 1;
  $nextpage   = $page + 1;

  echo'<ul class="pagination">';
  if ($page != 1) {
      echo '<li class="page-item"><a class="page-link" href="' . $url. '?pages=1">«</a></li>';
      echo '<li class="page-item"><a class="page-link" href="' . $url. '?pages=' . $prevpage . '">‹</li>';
      echo '<li class="page-item"><a class="page-link" href="' . $url. '?pages=1">1</a></li>&nbsp;&nbsp;...&nbsp;&nbsp;'; //Add first page link and ...
  }
  for($i = $start; ($i <= $end);/* && ($i<=$max_pages)*/ $i++){
      if($i == $page){
          echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
      }else{
          echo '<li class="page-item"><a class="page-link" href="' . $url. '?pages=' .$i.'">'.$i.'</a></li>';
      }
  }
  if ($page != $num_page){
      echo '&nbsp;&nbsp;...&nbsp;&nbsp;<li class="page-item"><a class="page-link" href="' . $url. '?pages=' . $num_page . '">' . $num_page . '</a></li>'; //Add last page link and ...
      echo '<li class="page-item"><a class="page-link" href="' . $url. '?pages=' .$nextpage.'">›</a></li>';
      echo '<li class="page-item"><a class="page-link" href="' . $url. '?pages='.$num_page.'" class="last">»</a></li>';
  }
  echo'</ul>';
}
?>