<?php

  $baseUrl = mkBaseUrl();
  $game = $page->getData();

?>

<div class="container">

  <!-- BREADCRUMB -->
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="<?php print $baseUrl; ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?php print $baseUrl; ?>/games">Games</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?php print $game['name']; ?></li>
    </ol>
  </nav>

  <!-- SETTINGS -->
  <!--<button id="changeLanguageBtn" class="btn btn-outline-secondary me-0 me-lg-3 d-none" type="button">
    <a href="<?php print $game['url']; ?>" class="link-light" title="Change Language">
      <i class="fas fa-cog"></i><span class="d-none d-lg-inline ms-2">Language</span>
    </a>
  </button>-->

</div>

<!-- LANGUAGE SELECTION -->
<!-- TODO make this a widget in color-picker -->
<div class="container d-none mb-3" id="gameLanguagesContainer">

<div class="row">

  <div class="col">

    <h1 class="visually-hidden"><?php print $game['name']; ?></h1>

    <div class="alert alert-success mt-3" role="alert">
      Choose a language to play <strong><?php print $game['name']; ?></strong>!
    </div>

    <ul class="list-group">
      <li class="list-group-item">
        <a href="<?php print $game['url']; ?>/es" title="Learn Color Names in Spanish">Spanish</a>
      </li>
      <li class="list-group-item">
        <a href="<?php print $game['url']; ?>/vi" title="Learn Color Names in Vietnamese">Vietnamese</a>
      </li>
    </ul>

  </div>

</div>

</div>

<!-- GAME CONTAINER -->
<div class="container d-none mb-3" id="gameContainer"></div>

<!-- TOAST -->
<div class="toast-container position-absolute p-3 bottom-0 start-50 translate-middle-x" id="toastPlacement" data-original-class="toast-container position-absolute p-3">
  <div id="liveToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

<!-- MODAL -->
<div class="modal fade text-dark" id="gameModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="gameModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer d-none">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">OK</button>
      </div>
    </div>
  </div>
</div>
