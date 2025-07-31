<script>
    const setused = async (status) => {
            @php
                $params = array(
                    'key' => $key, 
                    'user_id' => $user_id
                );
            @endphp

            const url = "{!! route('api.userwidget.setused') !!}";
            const data = JSON.parse('{!! json_encode($params) !!}');
            data['is_used'] = status;
            // console.log(data);
            const options = {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify(data)
            }

            const response = await fetch(url, options)
                .then(response => {
                    if (!response.ok) throw new Error(response.statusText);

                    return response.json();
                })
                .catch(error => {
                    console.log(`Request failed: ${error}`);

                    return false;
            });

            // console.log(response);
        }

        window.addEventListener('beforeunload', function (e) {
            const qParams = JSON.parse('{!! json_encode($qParams) !!}');
            if (!qParams['test']) {
                const status = 0;
                setused(status);
            }
        });
</script>