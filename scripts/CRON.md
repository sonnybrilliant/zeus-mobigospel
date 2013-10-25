./app/console rabbitmq:consumer -w -d -r 'song.full.encode' song_full_encode
./app/console rabbitmq:consumer -w -d -r 'song.full.tag' song_full_tag
./app/console rabbitmq:consumer -w -d -r 'song.preview.encode' song_preview_encode
