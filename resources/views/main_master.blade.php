<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href=" {{ asset('assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    @include('body.header')

    @yield('content')

    <script>
        function manageFavorite(characterId) {
            // Favori olarak eklenmiş mi kontrol et
            const isFavorite = document.getElementById(`favoriteButton_${characterId}`).innerText === 'Remove Favorite';
            // AJAX isteği gönder
            fetch(`/favorite/${isFavorite ? 'remove' : 'add'}/${characterId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        character_id: characterId
                    })
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    // Başarılı yanıt alındığında yapılacak işlemler
                    console.log(data.message);
                    // Buton metnini ve rengini güncelle
                    const favoriteButton = document.getElementById(`favoriteButton_${characterId}`);
                    if (isFavorite) {
                        favoriteButton.innerText = 'Add Favorite';
                        favoriteButton.classList.remove('btn-danger');
                        favoriteButton.classList.add('btn-color');
                    } else {
                        favoriteButton.innerText = 'Remove Favori';
                        favoriteButton.classList.remove('btn-color');
                        favoriteButton.classList.add('btn-danger');
                    }
                })
                .catch(error => {
                    console.error('There was an error!', error);
                });
        }
    </script>
    
    
</body>

</html>
