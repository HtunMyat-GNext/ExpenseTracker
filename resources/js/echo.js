import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'df4be5992a904e2828e3',
    cluster: 'ap1',
    encrypted: true
});
