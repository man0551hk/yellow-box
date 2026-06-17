<div class="container py-4">
  <div class="row">
    <!-- Conversations List -->
    <div class="col-lg-4 mb-4">
      <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
          <h6 class="mb-0 font-weight-bold"><?= Lang::$lang['myMessages'] ?></h6>
        </div>
        <div class="card-body p-0 chat-sidebar">
          <?php if (!empty($conversations)): ?>
            <?php foreach ($conversations as $conv): ?>
              <a href="<?= Url::getDomain() ?>inbox/<?= $conv['otherUserId'] ?>/" class="d-flex align-items-center p-3 text-dark text-decoration-none border-bottom <?= isset($activeConversation) && $activeConversation == $conv['otherUserId'] ? 'bg-light' : '' ?>">
                <div class="mr-3">
                  <?php if ($conv['user']['profilePic']): ?>
                    <img src="<?= $conv['user']['profilePic'] ?>" class="avatar">
                  <?php else: ?>
                    <div class="avatar bg-warning d-flex align-items-center justify-content-center text-white font-weight-bold">
                      <?= strtoupper(substr($conv['user']['firstName'], 0, 1)) ?>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="flex-grow-1 min-width-0">
                  <div class="d-flex justify-content-between">
                    <strong class="small"><?= htmlspecialchars($conv['user']['firstName'] . ' ' . $conv['user']['lastName']) ?></strong>
                    <?php if ($conv['unread'] > 0): ?>
                      <span class="badge badge-danger badge-pill"><?= $conv['unread'] ?></span>
                    <?php endif; ?>
                  </div>
                  <small class="text-muted text-truncate d-block"><?= htmlspecialchars(mb_substr($conv['lastMessage'], 0, 50)) ?></small>
                </div>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="empty-state">
              <i class="fas fa-comments"></i>
              <p><?= Lang::$lang['noMessages'] ?></p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <!-- Chat Area -->
    <div class="col-lg-8 mb-4">
      <div class="card border-0 shadow-sm">
        <?php if (isset($otherUser)): ?>
          <div class="card-header bg-white py-3 d-flex align-items-center">
            <div class="mr-3">
              <?php if ($otherUser['profilePic']): ?>
                <img src="<?= $otherUser['profilePic'] ?>" class="avatar">
              <?php else: ?>
                <div class="avatar bg-warning d-flex align-items-center justify-content-center text-white font-weight-bold">
                  <?= strtoupper(substr($otherUser['firstName'], 0, 1)) ?>
                </div>
              <?php endif; ?>
            </div>
            <div>
              <strong><?= htmlspecialchars($otherUser['firstName'] . ' ' . $otherUser['lastName']) ?></strong>
              <div class="small text-muted"><?= Lang::$lang['online'] ?></div>
            </div>
          </div>
          
          <div class="card-body chat-messages" id="chatMessages">
            <?php if (!empty($messages)): ?>
              <?php foreach ($messages as $msg): ?>
                <div class="message-bubble <?= $msg['fromUserId'] == Session::get('userId') ? 'message-sent' : 'message-received' ?>">
                  <div class="small"><?= nl2br(htmlspecialchars($msg['content'])) ?></div>
                  <div class="small text-muted text-right mt-1" style="font-size:0.7rem;">
                    <?= date('H:i', strtotime($msg['sentDate'])) ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          
          <div class="card-footer bg-white">
            <form method="POST" action="" class="d-flex">
              <input type="text" class="form-control mr-2" name="content" placeholder="<?= Lang::$lang['typeMessage'] ?>" required>
              <button type="submit" class="btn btn-yellow"><?= Lang::$lang['send'] ?></button>
            </form>
          </div>
        <?php else: ?>
          <div class="empty-state">
            <i class="fas fa-comment-dots"></i>
            <h5><?= Lang::$lang['inboxBanner'] ?></h5>
            <p><?= Session::get("lang") == "tc" ? "揀一個對話開始傾計" : "Select a conversation to start chatting" ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
// Scroll to bottom of chat
var chatMessages = document.getElementById('chatMessages');
if (chatMessages) {
  chatMessages.scrollTop = chatMessages.scrollHeight;
}
</script>
