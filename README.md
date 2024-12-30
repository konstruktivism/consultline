<p align="center"><a href="https://consultline.konstruktiv.nl" target="_blank">
    <img width="1061" style="border-radius: 12px; overflow: hidden; alt="Screenshot 2024-12-30 at 11 58 22" src="https://github.com/user-attachments/assets/1bdff951-c627-40dd-a240-53f8288f4b1f" />
</a></p>

## About Consultline
A proof of Concept of the Laravel Reverb package to start a online consulting platform. Consultline is a web application that allows users to ask question and get realtime answers, the site uses browser notifications to get notified.

## Features
- **Create a free account**: without setting a password.
- **Login via e-mail**: 1 click login via e-mail.
- **Realtime Chat**: Receive fast replies via a realtime chat.

## VapidKeys
Us the generateVapidKeys.js to set the VAPID_PUBLIC_KEY and VAPID_PRIVATE_KEY in the .env file.

## nginx configuration
Add the following configuration to your nginx configuration file:
```
# Laravel Reverb
    # The Websocket Client/Laravel Echo would connect and listen to this
    location ~ /app/ { # variable reverbkey
        proxy_pass http://127.0.0.1:8080;
        proxy_http_version 1.1;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header SERVER_PORT $server_port;
        proxy_set_header REMOTE_ADDR $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "Upgrade";
    }
    # The Laravel Backend would broadcast to this
    location ~ /apps/ { # variable reverbid
        proxy_pass http://127.0.0.1:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
```

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). 

<p align="center"><a href="https://consultline.konstruktiv.nl" target="_blank">
<img width="1058" alt="Screenshot 2024-12-30 at 11 58 40" src="https://github.com/user-attachments/assets/8a3124fd-465f-4086-bf9f-32e7fc5bbf22" />
</a></p>

<p align="center"><a href="https://consultline.konstruktiv.nl" target="_blank">
<img width="1058" alt="Screenshot 2024-12-30 at 12 00 40" src="https://github.com/user-attachments/assets/b53dfc25-a914-4dd1-87a4-758b9d59a063" />
</a></p>

<p align="center"><a href="https://consultline.konstruktiv.nl" target="_blank">
<img width="690" alt="Screenshot 2024-12-28 at 14 38 33" src="https://github.com/user-attachments/assets/a3e0fe1f-7cf1-4ae5-ad8c-9fb20afc5b77" />
</a></p>
