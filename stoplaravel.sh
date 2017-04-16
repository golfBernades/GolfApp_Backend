running_id=$(lsof -t -i:8000)

if [ -z "$running_id" ];
then
    echo Laravel no estaba corriendo
else
    echo Laravel está corriendo
    kill $running_id
    echo Laravel se detuvo
fi
