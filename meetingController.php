<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\meeting;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class meetingController extends Controller
{
    public function follow_request(Request $request)
    {
        $sender = User::where('idt',0);

        $receiver = User::where('name',$request);

        $sender->followRequest($receiver);

        $request->validate
        (
            [
                'sender'=>'required',
                'receiver'=>'required'
            ]
        );

        \App\Models\Request::create
        (
            [
                'sender'=>$request->sender_id,
                'receiver'=>$request->receiver_id,
                'status'=>0
            ]
        );

        $sender->followRequests()->count();

        $receiver->followerRequests()->count();
    }

    public function cancel_request() //اینجا باید بگیم اونی که ریکوست داده بود حالا میخواد برداره ریکوستشو
    {
        Auth::check();
        $cancelRequest=  \App\Models\Request::where('sender', auth()->id());
        $cancelRequest->delete();
    }

    public function accept_request(Request $request): RedirectResponse
    {
        Auth::check();

        $sender = User::where('idt',0);

        $receiver = User::where('name',$request);

        $receiver->acceptFollowRequest($sender);

        $sender->followRequest()->count(-1);

        $receiver->followerRequests()->count(-1);

        $request->validate
        (
            [
                'stu_id'=>'required',
                'prof_id'=>'required'

            ]
        );

        Follower::create
        (
            [
                'stu_id'=>$request->sender,
                'prof_id'=>$request->receiver
            ]
        );

        $sender->follows($receiver);

        return redirect()->back('200');
    }

    public function decline_request(Request $request)  //اونی که ریکوست رو دریافت کرده میخواد ردش کنه
    {
//        $sender = User::where('idt',0);
//
//        $receiver = User::where('name', $request);
//
//        $declineFollowRequest= $receiver->declineFollowRequest($sender);
//
//        $declineFollowRequest->where( $sender , $request );
//
//        $declineFollowRequest->Request::class()->delete();
        Auth::check();
        $declineRequest =  \App\Models\Request::where('receiver', auth()->id());
        $declineRequest->delete();

    }

    public function create()
    {
        if(Auth::check())
        {
            meeting::with('users')
                ->where('idCreateMeeting', auth()->id())
                ->orWhere('id_follower', auth()->id())
                ->get();
            return view('meeting');
        }

    }

    public function store(Request $request)
    {
        $request->validate
        ([
            'title'=>'required|max255',
            'location'=>'required|max255',
            'time'=>'required',
            'id_follower'
        ]);

        $meeting= meeting::create
        ([
            'title'=>$request->title,
            'location'=>$request->location,
            'doc'=>$request->doc,
            'time'=>$request->time,
            'id_follower'=>$request->id_follower

        ]);

        return response($meeting,200);
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(meeting $meeting): RedirectResponse
    {
//        $user= Auth::check();
//        $meeting= meeting::where('idCreateMeeting', auth()->id());
//        if (Gate::forUser($user)->allows('delete_meeting', $meeting))
//        {
//           return view('meeting.delete', $meeting->delete());
//        }else
//        {
//            abort(403);
//        }
        $this->authorize('delete_meeting');
        $meeting->delete();
        return redirect()->route('create_meeting');
    }

    /**
     * @throws AuthorizationException
     */
    public function reconsider_meeting(meeting $meeting, Request $request): RedirectResponse
    {
//        $user= Auth::check();
//        $meeting= meeting::where('id_follower', auth()->id());
//        if (Gate::forUser($user)->allows('reconsider_meeting',$meeting))
//        {
//            return view('meeting.reconsider', compact('meeting'));
//        }else
//        {
//            abort(403);
//        }

        $this->authorize('reconsider_meeting');
        $meeting->update($request->only('comment'));
        return redirect()->route('create_meeting');
    }

    /**
     * @throws AuthorizationException
     */
    public function accept_meeting( meeting $meeting)   //مطمئن نیستم که درست باشه
    {
        $this->authorize('accept_meeting');
        $meeting->status->update(3);
    }

    public function meeting_in_home_page_for_table()
    {
      $meeting=  meeting::with('users')
            ->where('idCreateMeeting', auth()->id())
            ->orWhere('id_follower', auth()->id())
            ->where('meeting_status',3)
            ->orderBy('time','desc')
            ->get();
        dd($meeting);
    }

    public function meeting_in_home_page_for_calendar()
    {
        meeting::with('users')
            ->where('idCreateMeeting',auth()->id())
            ->orWhere('id_follower', auth()->id())
            ->where('meeting_status',3)
            ->orderBy('time','desc')
            ->get();
    }

    public function each_user_profile()
    {
        Auth::check();
        User::where('id', auth()->id())->get();
        return view('profile');
    }
}
