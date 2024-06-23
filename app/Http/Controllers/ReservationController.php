<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reservations = Reservation::where('user_id', $user->id)
            ->with('store')
            ->orderBy('reservation_date', 'desc') // 来店日順に並び替え
            ->get();

        return view('reservation.index', compact('reservations'));
    }

    public function show($id)
    {
        $reservation = Reservation::with('store')->findOrFail($id);

        // 店舗の中間テーブルに紐づいているカテゴリーのリストを取得する
        $store = Store::find($reservation->store->id);
        $categories = $store->categories;

        return view('reservation.show', compact('reservation', 'categories'));
    }

    public function create($store_id)
    {
        return view('reservation.create', ['store_id' => $store_id]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'reservation_date' => 'required|date',
            'number_of_people' => 'required|integer|min:1',
            'store_id' => 'required|integer',
        ]);

        $isoDateTime = $request->input('reservation_date');
        // "T"で日付と時刻を分割し、日付と時刻を別々の変数に格納する
        list(
            $date, $time
        ) = explode("T", $isoDateTime);
        // MySQLの日付の形式に変換する
        $mysqlDate = $date;
        // MySQLの時刻の形式に変換する
        $mysqlTime = substr($time, 0, 5) . ":00"; // 秒の部分は"00"にする
        // // MySQLの日付と時刻の形式に変換した値を出力する
        // echo "MySQL Date: $mysqlDate\n";
        // echo "MySQL Time: $mysqlTime\n";

        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->store_id = $request->input('store_id');
        $reservation->reservation_date = $mysqlDate . " " . $mysqlTime;
        $reservation->number_of_people = $request->input('number_of_people');
        $reservation->status = 'tentative'; //仮予約というステータス
        $reservation->save();

        //return redirect()->back()->with('success', '仮予約が完了致しました。予約確定メールをお待ちください。');

        return redirect()->route('reservation.create', ['store_id' => $reservation->store_id])
            ->with('success', '予約が完了しました.');
    }

    public function destroy($id)
    {
        $reservation = Reservation::with('store')->findOrFail($id);

        // 現在時刻を取得
        $now = Carbon::now();

        // 予約の来店日時を取得
        $reservationDate = Carbon::parse($reservation->reservation_date);

        // もし予約の来店日時が現在時刻より前であれば、キャンセルを許可しない
        if ($reservationDate->lt($now)) {
            return redirect()->route('reservation.index')->with('error', '過去の予約はキャンセルできません。');
        }

        // キャンセル処理
        $reservation->delete();

        return redirect()->route('reservation.index')->with('success', '予約をキャンセルしました。');
    }
}
