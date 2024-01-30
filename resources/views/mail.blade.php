@component('mail::message')
    <div style="background-color: #f7f7f7; padding: 20px; text-align: center;">
        <h1 style="color: #333; font-size: 24px; margin-bottom: 10px;">Your Timeline</h1>
        <p style="color: #555; font-size: 16px; margin-bottom: 20px;">
            Dear User,
        </p>
        <p style="color: #555; font-size: 16px; margin-top: 20px;">
            Click the button below and see your timeline.
        </p>
        @component('mail::button', ['url' => $link])
            Click Here
        @endcomponent
        <p style="color: #555; font-size: 16px; margin-top: 20px;">
            Thanks,<br>
            Christopher Shawn Hernandez
        </p>
    </div>
@endcomponent

