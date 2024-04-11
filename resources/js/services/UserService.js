

   function getChatUsers(){
        return  axios.get('/chat/users')
            .then(function (response) {
                return  response;
            })
            .catch(function (error) {
                return  error;
            });
    }

    function getUsers(){
        return  axios.get('/users')
            .then(function (response) {
                return  response;
            })
            .catch(function (error) {
                return  error;
            });
    }


export default { getChatUsers, getUsers }
