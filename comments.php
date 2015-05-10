<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }

    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>

<li id="li-<?php $comments->theId(); ?>" class="<?php
if ($comments->levels > 0) {
    echo 'comment-child';
} else {
    echo 'comment-parent';
}
?>">
    <div id="<?php $comments->theId(); ?>">
        <?php $comments->gravatar('80', ''); ?>
        <div class="comment-main">
            <span class="comment-author"><?php $comments->author(); ?></span>
            <?php $comments->content(); ?>
            <div class="comment-meta"><time class="comment-time"><?php $comments->date('n月j日'); ?></time><span class="comment-reply"><?php $comments->reply(); ?></span></div>
        </div>
    </div>

<?php if ($comments->children) { ?>
    <div class="comment-children">
        <?php $comments->threadedComments($options); ?>
    </div>
<?php } ?>
</li>
<?php } ?>

<div id="comments" class="post">
    <h3 class="post-title">评论</h3>
    <?php $this->comments()->to($comments); ?>
        <?php if($this->allow('comment')): ?>
            <div class="post-meta"><?php $this->commentsNum(_t('暂无评论'), _t('1 条评论'), _t('%d 条评论')); ?></div>

            <div id="<?php $this->respondId(); ?>" class="respond">
                <div class="cancel-comment-reply">
                    <?php $comments->cancelReply(); ?>
                </div>

                <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
                    <?php if (!$this->user->hasLogin()): ?>
                    <div>
                        <input type="text" name="author" maxlength="12" id="author" class="text" placeholder="<?php _e('昵称 *'); ?>" value="<?php $this->remember('author'); ?>" required><input type="email" name="mail" id="mail" class="text" placeholder="<?php _e('邮箱 *'); ?>" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>><input type="url" name="url" id="url" class="text" placeholder="<?php _e('网址'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?>>
                    </div>
                    <?php endif; ?>
                    <div>
                        <textarea name="text" id="textarea" class="textarea" placeholder="<?php _e('试试用 Ctrl/Cmd+Enter 提交吧？'); ?>" required ><?php $this->remember('text'); ?></textarea>
                    </div>
                    <div>
                        <button type="submit" id="submit"><?php _e('提交评论'); ?></button>
                    </div>
                </form>
            </div>

            <?php if ($comments->have()): ?>
                <?php $comments->listComments(); ?>
                <?php $comments->pageNav('&laquo;', '&raquo;'); ?>
            <?php endif; ?>
        <?php else: ?>
            <div class="post-meta">评论已关闭</div>
        <?php endif; ?>
</div>
