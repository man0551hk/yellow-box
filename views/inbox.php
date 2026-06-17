<?php $activePage = 'inbox'; $isTc = Session::get("lang") == "tc"; ?>

<div class="page-title-overlap bg-img pt-4">
  <div class="container d-lg-flex justify-content-between py-2 py-lg-3">
    <div class="order-lg-2 mb-3 mb-lg-0 pt-lg-2">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-dark flex-lg-nowrap justify-content-center justify-content-lg-start">
          <li class="breadcrumb-item"><a class="text-nowrap" href="<?= Url::getDomain() ?>"><i class="czi-home"></i>Home</a></li>
          <li class="breadcrumb-item text-nowrap active" aria-current="page"><?= Lang::$lang['myMessages'] ?></li>
        </ol>
      </nav>
    </div>
    <div class="order-lg-1 pr-lg-4 text-center text-lg-left">
      <h1 class="h3 text-dark mb-0"><?= Lang::$lang['myMessages'] ?></h1>
    </div>
  </div>
</div>

<div class="container pb-5 mb-2 mb-md-4">
  <div class="row">
    <div class="col-lg-4 mb-4 mb-lg-0">
      <div class="cz-sidebar-static rounded-lg box-shadow-lg px-0 overflow-hidden">
        <div class="bg-secondary px-4 py-3">
          <h3 class="font-size-sm mb-0 text-muted"><i class="czi-comment mr-1"></i><?= Lang::$lang['myMessages'] ?></h3>
        </div>
        <div data-simplebar data-simplebar-auto-hide="false" style="max-height:28rem;">
          <?php if (!empty($conversations)): ?>
            <?php foreach ($conversations as $conv): ?>
              <a href="<?= Url::getDomain() ?>inbox/<?= $conv['otherUserId'] ?>/" class="d-flex align-items-center px-4 py-3 text-dark text-decoration-none border-bottom<?= isset($activeConversation) && $activeConversation == $conv['otherUserId'] ? ' bg-secondary' : '' ?>">
                <div class="mr-3 position-relative flex-shrink-0">
                  <?php if ($conv['user']['profilePic']): ?>
                    <img src="<?= $conv['user']['profilePic'] ?>" class="rounded-circle" width="44" height="44" alt="">
                  <?php else: ?>
                    <div class="rounded-circle bg-accent text-white d-flex align-items-center justify-content-center font-weight-bold" style="width:44px;height:44px;">
                      <?= strtoupper(substr($conv['user']['firstName'], 0, 1)) ?>
                    </div>
                  <?php endif; ?>
                  <?php if ($conv['unread'] > 0): ?>
                    <span class="badge badge-danger badge-pill position-absolute" style="top:-4px;right:-4px;"><?= $conv['unread'] ?></span>
                  <?php endif; ?>
                </div>
                <div class="flex-grow-1 min-width-0">
                  <div class="font-size-sm font-weight-medium"><?= htmlspecialchars($conv['user']['firstName'] . ' ' . $conv['user']['lastName']) ?></div>
                  <div class="font-size-xs text-muted text-truncate"><?= htmlspecialchars(mb_substr($conv['lastMessage'], 0, 50)) ?></div>
                </div>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="text-center py-5 px-3">
              <i class="czi-comment" style="font-size:3rem;color:#ccc;"></i>
              <p class="text-muted mt-2 mb-0"><?= Lang::$lang['noMessages'] ?></p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="bg-secondary rounded-lg box-shadow-lg overflow-hidden">
        <?php if (isset($otherUser)): ?>
          <div class="px-4 py-3 border-bottom d-flex align-items-center bg-light">
            <?php if ($otherUser['profilePic']): ?>
              <img src="<?= $otherUser['profilePic'] ?>" class="rounded-circle mr-3" width="44" height="44" alt="">
            <?php else: ?>
              <div class="rounded-circle bg-accent text-white d-flex align-items-center justify-content-center font-weight-bold mr-3" style="width:44px;height:44px;">
                <?= strtoupper(substr($otherUser['firstName'], 0, 1)) ?>
              </div>
            <?php endif; ?>
            <div>
              <strong class="text-dark"><?= htmlspecialchars($otherUser['firstName'] . ' ' . $otherUser['lastName']) ?></strong>
              <div class="font-size-xs text-muted"><i class="czi-check-circle text-success mr-1"></i><?= Lang::$lang['online'] ?></div>
            </div>
          </div>

          <div class="px-4 py-3 chat-messages" id="chatMessages" style="min-height:20rem;max-height:28rem;overflow-y:auto;" data-simplebar data-simplebar-auto-hide="false">
            <?php if (!empty($messages)): ?>
              <?php foreach ($messages as $msg): ?>
                <div class="mb-3 d-flex<?= $msg['fromUserId'] == Session::get('userId') ? ' justify-content-end' : '' ?>">
                  <div class="rounded-lg px-3 py-2 font-size-sm<?= $msg['fromUserId'] == Session::get('userId') ? ' bg-primary text-white' : ' bg-light' ?>" style="max-width:75%;">
                    <?= nl2br(htmlspecialchars($msg['content'])) ?>
                    <div class="font-size-xs opacity-75 text-right mt-1"><?= date('H:i', strtotime($msg['sentDate'])) ?></div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>

          <div class="px-4 py-3 border-top bg-light">
            <form method="POST" action="" class="input-group">
              <input type="text" class="form-control" name="content" placeholder="<?= Lang::$lang['typeMessage'] ?>" required>
              <div class="input-group-append">
                <button type="submit" class="btn btn-primary btn-shadow"><i class="czi-send mr-1"></i><?= Lang::$lang['send'] ?></button>
              </div>
            </form>
          </div>
        <?php else: ?>
          <div class="text-center py-5">
            <i class="czi-comment-dots" style="font-size:4rem;color:#ccc;"></i>
            <h5 class="mt-3"><?= Lang::$lang['inboxBanner'] ?></h5>
            <p class="text-muted"><?= $isTc ? "揀一個對話開始傾計" : "Select a conversation to start chatting" ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
var chatMessages = document.getElementById('chatMessages');
if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;
</script>