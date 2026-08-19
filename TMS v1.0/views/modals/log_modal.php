<!-- ================= LOGS MODAL ================= -->
<div class="modal-overlay" id="logsModalOverlay">
    <div class="modal" style="max-width:840px;">
        <div class="modal-head">
            <h2>Activity Logs</h2>
            <button class="modal-close" id="logsModalClose"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg></button>
        </div>
        <div class="modal-body">
            <div class="logs-toolbar">
                <select class="select-filter" id="logsUserFilter"></select>
                <div class="logs-toolbar-right">
                    <input type="text" id="logsSearchInput" placeholder="Search logs…">
                    <button type="button" class="logs-clear-btn" id="logsClearBtn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z" />
                        </svg>
                        Clear Logs
                    </button>
                </div>
            </div>
            <div class="logs-table-wrap">
                <table class="logs-table">
                    <thead>
                        <tr>
                            <th>Logs</th>
                            <th class="logs-date-col">Date &amp; Time</th>
                        </tr>
                    </thead>
                    <tbody id="logsTableBody"></tbody>
                </table>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn-primary-modal" id="logsModalDone">Done</button>
        </div>
    </div>
</div>