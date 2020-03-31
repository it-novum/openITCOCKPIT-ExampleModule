<?php
/**
 * @var \App\View\AppView $this
 * @var string $message
 */
?>

<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    <?php echo __('Example Module'); ?>
                    <span class="fw-300"><i><?php echo __('Hello World'); ?></i></span>
                </h2>
            </div>
            <div class="panel-container show">
                <div class="panel-content">

                    <!-- Output "Hello World (HTML)" that was set by the controller -->
                    <?= h($message); ?>

                    <table class="table table-striped m-0 table-bordered table-hover table-sm">
                        <thead>
                        <tr>
                            <th><?= __('Host name') ?></th>
                            <th><?= __('Note') ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <!-- Repeat this TR for each record in $scope.notes -->
                        <tr ng-repeat="note in notes">
                            <td>
                                <!-- Print the content of the variable -->
                                {{ note.host.name }}
                            </td>
                            <td>{{ note.notes }}</td>
                        </tr>
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
