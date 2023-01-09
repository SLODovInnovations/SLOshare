<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\UpdateReportRequest;
use App\Models\PrivateMessage;
use App\Models\Report;

/**
 * @see \Tests\Todo\Feature\Http\Controllers\ReportControllerTest
 */
class ReportController extends Controller
{
    /**
     * Display All Reports.
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $reports = Report::orderBy('solved')->latest()->paginate(25);

        return \view('Staff.report.index', ['reports' => $reports]);
    }

    /**
     * Show A Report.
     */
    public function show(int $id): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $report = Report::findOrFail($id);

        \preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', (string) $report->message, $match);

        return \view('Staff.report.show', ['report' => $report, 'urls' => $match[0]]);
    }

    /**
     * Update A Report.
     */
    public function update(UpdateReportRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $staff = \auth()->user();
        $report = Report::findOrFail($id);

        if ($report->solved == 1) {
            return \to_route('staff.reports.index')
                ->withErrors('To poročilo je že rešeno');
        }

        $report->update(['solved' => 1, 'staff_id' => $staff->id] + $request->validated());

        // Send Private Message
        PrivateMessage::create([
            'sender_id'   => $staff->id,
            'receiver_id' => $report->reporter_id,
            'subject'     => 'Vaše poročilo ima novo sodbo',
            'message'     => '[b]NASLOV POROČILA:[/b] '.$report->title."\n\n[b]ORIGINALNO SPOROČILO:[/b] ".$report->message."\n\n[b]SODBA:[/b] ".$report->verdict,
        ]);

        return \to_route('staff.reports.index')
            ->withSuccess('Poročilo je bilo uspešno rešen');
    }
}
