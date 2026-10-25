<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <title>Latest Lottery Draw Results</title>
</head>
<body>
    @if(!empty($subscriber))
    <p style="margin: 0; font-size: 16px; line-height: 1.1;">{{ $subscriber->subscriber_name }} Expiry Date is : {{ $subscriber->formatted_expiry_date }}</p>
    @endif

    <h3 style="margin: 0; font-size: 16px; font-weight: bold; line-height: 1.1;">Latest Lottery Draw Results</h3>

    @if(!empty($expiringSoon))
    <p id="expiry-warning" style="margin: 0 0 4px 0; font-size: 24px; font-weight: bold; color: #FF0000; line-height: 1.1;">Software expiring soon! Please contact us.</p>
    <p style="margin: 0 0 6px 0;"><img src="/images/gpay.jpg" alt="Google Pay" width="240" height="149" border="0"></p>
    <script type="text/javascript">
    (function () {
        var el = document.getElementById('expiry-warning');
        if (!el) return;
        var on = true;
        window.setInterval(function () {
            on = !on;
            el.style.visibility = on ? 'visible' : 'hidden';
        }, 500);
    })();
    </script>
    @endif

    <table border="1" cellpadding="3" cellspacing="0" width="650">
        <tr>
            <th align="left" width="320">Lottery/DrawNo</th>
            <th align="left" width="85">Draw Date</th>
            <th align="left" width="65">Status</th>
            <th align="center" width="90">Download</th>
            <th align="center" width="90">Print</th>
            <th width="0" style="width:0; padding:0; margin:0; border:0; overflow:hidden; font-size:0; line-height:0;">Description</th>
        </tr>
        @forelse($draws as $draw)
        <tr {!! (request('hl') && $loop->first && $draws->onFirstPage()) ? 'bgcolor="#ffff99" style="background-color:#ffff99;"' : '' !!}>
            <td>{{ $draw->display_label }}</td>
            <td>{{ $draw->formatted_draw_date }}</td>
            <td>{{ $draw->status ?: 'Live' }}</td>
            <td align="center">
                @if($draw->file_path)
                <a href="/lottery/results/{{ $draw->id }}/download">Download</a>
                @else
                -
                @endif
            </td>
            <td align="center">
                @if($draw->file_path)
                <a href="/lottery/results/{{ $draw->id }}/download">Print</a>
                @else
                -
                @endif
            </td>
            <td width="0" style="width:0; padding:0; margin:0; border:0; overflow:hidden; font-size:0; line-height:0;">{{ $draw->description ?: '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" align="center">No lottery results available yet.</td>
        </tr>
        @endforelse
    </table>

    @if($draws->hasPages())
    <p style="margin-top: 12px; font-size: 14px;">
        Showing {{ $draws->firstItem() }}-{{ $draws->lastItem() }} of {{ $draws->total() }}
        &nbsp;|&nbsp;
        @if($draws->onFirstPage())
            Previous
        @else
            <a href="{{ $draws->previousPageUrl() }}">Previous</a>
        @endif
        &nbsp;|&nbsp;
        Page {{ $draws->currentPage() }} of {{ $draws->lastPage() }}
        &nbsp;|&nbsp;
        @if($draws->hasMorePages())
            <a href="{{ $draws->nextPageUrl() }}">Next</a>
        @else
            Next
        @endif
    </p>
    @endif

    <script type="text/javascript">
    (function () {
        var versionUrl = '/lottery/results/version';
        var lastVersion = null;
        var checking = false;

        function createXhr() {
            if (window.XMLHttpRequest) {
                return new XMLHttpRequest();
            }
            try { return new ActiveXObject('Microsoft.XMLHTTP'); } catch (e) {}
            try { return new ActiveXObject('Msxml2.XMLHTTP'); } catch (e2) {}
            return null;
        }

        function checkVersion() {
            if (checking) return;
            var xhr = createXhr();
            if (!xhr) return;

            checking = true;
            xhr.open('GET', versionUrl + '?t=' + new Date().getTime(), true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState !== 4) return;
                checking = false;
                if (xhr.status !== 200) return;

                var version = '';
                try {
                    var text = xhr.responseText || '';
                    var m = text.match(/"version"\s*:\s*"([^"]*)"/);
                    if (m && m[1]) version = m[1];
                } catch (err) {
                    return;
                }

                if (!version) return;

                if (lastVersion === null) {
                    lastVersion = version;
                    return;
                }

                if (version !== lastVersion) {
                    window.location.href = '/lottery/results?hl=1';
                }
            };
            try {
                xhr.send(null);
            } catch (sendErr) {
                checking = false;
            }
        }

        checkVersion();
        window.setInterval(checkVersion, 5000);
    })();
    </script>
</body>
</html>
