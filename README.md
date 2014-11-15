MOZNA ANI NEBUDES POTREBOVAT


instalace node.js:

    mozna bude stacit `sudo apt-get install nodejs`
    jestli ne tak funguje tohle:

    instalace kompilacnich nastroju aj.:

        sudo apt-get update
        sudo apt-get install git-core curl build-essential openssl libssl-dev

    stazeni repozitare / zdrojaku / binarek:

        git clone https://github.com/joyent/node.git
            nebo jeste lepe stahnout verzi primo z webu, je tam vyssi verze: http://nodejs.org/download/
        cd node
        git tag # Gives you a list of released versions
        git checkout v0.4.12

    kompilace: 

        ./configure
        make
        sudo make install


instalace npm:

    sudo curl https://www.npmjs.org/install.sh | sudo sh

instalace bootstrapu:

    npm install bootstrap
