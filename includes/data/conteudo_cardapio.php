<?php

return [
    'secoes' => [
        'salgados' => ['label' => 'Pratos Salgados', 'eyebrow' => 'Culinária Baiana', 'icon' => 'fa-bowl-food'],
        'sobremesas' => ['label' => 'Sobremesas', 'eyebrow' => 'Doce Final', 'icon' => 'fa-cake-candles'],
        'bebidas' => ['label' => 'Bebidas', 'eyebrow' => 'Para Acompanhar', 'icon' => 'fa-glass-water'],
    ],
    'cardapio' => [
        'salgados' => [
            ['id' => 'moqueca', 'nome' => 'Moqueca de Peixe', 'desc' => 'Peixe fresco cozido no leite de coco, azeite de dendê, pimentão e coentro. Acompanha arroz e pirão.', 'preco' => 52.90, 'img' => '../assets/img/moqueca.jpg', 'destaque' => true],
            ['id' => 'feijoada', 'nome' => 'Feijoada Baiana', 'desc' => 'Feijão preto com carnes selecionadas, couve refogada, farofa e laranja. Tradição que aquece.', 'preco' => 44.90, 'img' => '../assets/img/feijoada.jpg', 'destaque' => false],
            ['id' => 'vatapa', 'nome' => 'Vatapá', 'desc' => 'Creme encorpado de pão, amendoim, camarão seco, leite de coco e azeite de dendê.', 'preco' => 38.50, 'img' => '../assets/img/vatapa.jpg', 'destaque' => false],
            ['id' => 'caruru', 'nome' => 'Caruru', 'desc' => 'Quiabo refogado com camarão seco, amendoim, castanha de caju e azeite de dendê.', 'preco' => 36.00, 'img' => '../assets/img/caruru.jpg', 'destaque' => false],
            ['id' => 'acaraje', 'nome' => 'Acarajé', 'desc' => 'Bolinho de feijão-fradinho frito no dendê, recheado com vatapá, caruru e camarão.', 'preco' => 22.00, 'img' => '../assets/img/acaraje.jpg', 'destaque' => true],
            ['id' => 'bobo_camarao', 'nome' => 'Bobó de Camarão', 'desc' => 'Camarão fresco em creme de mandioca com leite de coco e azeite de dendê. Servido com arroz.', 'preco' => 58.00, 'img' => '../assets/img/bobo_camarao.jpg', 'destaque' => false],
            ['id' => 'galinha_caipira', 'nome' => 'Galinha à Caipira', 'desc' => 'Frango caipira ensopado com temperos baianos, servido com pirão e arroz branco.', 'preco' => 46.00, 'img' => '../assets/img/galinha_caipira.jpg', 'destaque' => false],
        ],
        'sobremesas' => [
            ['id' => 'cocada', 'nome' => 'Cocada de Forno', 'desc' => 'Cocada cremosa assada com coco fresco ralado, leite condensado e gemas caramelizadas.', 'preco' => 14.50, 'img' => '../assets/img/cocada.jpg', 'destaque' => true],
            ['id' => 'quindim', 'nome' => 'Quindim',              'desc' => 'Doce clássico baiano de gema de ovo, coco ralado e calda de açúcar. Textura sedosa.', 'preco' => 12.00, 'img' => '../assets/img/quindim.jpg', 'destaque' => false],
            ['id' => 'manjar', 'nome' => 'Manjar de Coco',       'desc' => 'Manjar branco cremoso com calda de ameixa preta. Refrescante e delicado.', 'preco' => 15.90, 'img' => '../assets/img/manjar.jpg', 'destaque' => false],
            ['id' => 'pe_de_moleque', 'nome' => 'Pé de Moleque',        'desc' => 'Doce rústico de amendoim torrado com rapadura e caldo de cana. Crocante e intenso.', 'preco' => 9.00, 'img' => '../assets/img/pe_de_moleque.jpg', 'destaque' => false],
        ],
        'bebidas' => [
            ['id' => 'suco_acerola', 'nome' => 'Suco de Acerola', 'desc' => 'Acerola fresca batida na hora, rica em vitamina C. Servida gelada.', 'preco' => 10.00, 'img' => '../assets/img/suco_de_acerola.jpg', 'destaque' => false],
            ['id' => 'agua_coco', 'nome' => 'Água de Coco', 'desc' => 'Coco verde gelado, aberto na hora. Natural, refrescante e hidratante.', 'preco' => 8.50, 'img' => '../assets/img/agua_de_coco.jpg', 'destaque' => true],
            ['id' => 'suco_caja', 'nome' => 'Suco de Cajá', 'desc' => 'Fruta típica do Nordeste batida com água e pouco açúcar. Sabor único e tropical.', 'preco' => 11.00, 'img' => '../assets/img/suco_de_caja.jpg', 'destaque' => false],
            ['id' => 'licor_jabuticaba', 'nome' => 'Licor de Jabuticaba', 'desc' => 'Licor artesanal feito com jabuticabas colhidas localmente. Encorpado e aromático.', 'preco' => 16.00, 'img' => '../assets/img/licor_de_jabuticaba.jpg', 'destaque' => false],
        ],
    ],
];