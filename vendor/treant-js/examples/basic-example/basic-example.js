//var config = {
//        container: "#basic-example",
//		rootOrientation: 'WEST',
//        connectors: {
//            type: 'step'
//        },
//        node: {
//            HTMLclass: 'nodeExample1',
//			collapsable: true
//        }
//    },
//    ceo = {
//        text: {
//            name: "Mark Hill",
//            title: "Chief executive officer",
//            contact: "Tel: 01 213 123 134",
//        },
//        image: "../headshots/2.jpg"
//    },
//
//    cto = {
//        parent: ceo,
//		collapsed: true,
//        text:{
//            name: "Joe Linux",
//            title: "Chief Technology Officer",
//        },
//        stackChildren: true,
//        image: "../headshots/1.jpg"
//    },
//    cbo = {
//        parent: ceo,
//        stackChildren: true,
//        text:{
//            name: "Linda May",
//            title: "Chief Business Officer",
//        },
//        image: "../headshots/5.jpg"
//    },
//    cdo = {
//        parent: ceo,
//        text:{
//            name: "John Green",
//            title: "Chief accounting officer",
//            contact: "Tel: 01 213 123 134",
//        },
//        image: "../headshots/6.jpg"
//    },
//    cio = {
//        parent: cto,
//        text:{
//            name: "Ron Blomquist",
//            title: "Chief Information Security Officer"
//        },
//        image: "../headshots/8.jpg"
//    },
//    ciso = {
//        parent: cto,
//        text:{
//            name: "Michael Rubin",
//            title: "Chief Innovation Officer",
//            contact: {val: "we@aregreat.com", href: "mailto:we@aregreat.com"}
//        },
//        image: "../headshots/9.jpg"
//    },
//    cio2 = {
//        parent: cdo,
//        text:{
//            name: "Erica Reel",
//            title: "Chief Customer Officer"
//        },
//        link: {
//            href: "http://www.google.com"
//        },
//        image: "../headshots/10.jpg"
//    },
//    ciso2 = {
//        parent: cbo,
//        text:{
//            name: "Alice Lopez",
//            title: "Chief Communications Officer"
//        },
//        image: "../headshots/7.jpg"
//    },
//
//	ciso3 = {
//        parent: cbo,
//        text:{
//            name: "Mary Johnson",
//            title: "Chief Brand Officer"
//        },
//        image: "../headshots/4.jpg"
//    },
//    ciso4 = {
//        parent: cbo,
//        text:{
//            name: "Kirk Douglas",
//            title: "Chief Business Development Officer"
//        },
//        image: "../headshots/11.jpg"
//    },
//    ciso5 = {
//        parent: ciso3,
//        text:{
//            name: "Kirdsdasdk Douglas",
//            title: "Chief Business Development Officer"
//        },
//        image: "../headshots/11.jpg"
//    },
//    ciso6 = {
//        parent: ciso3,
//        text:{
//            name: "Kirkdsadads Douglas",
//            title: "Chief Business Development Officer"
//        },
//        image: "../headshots/11.jpg"
//    },
//    ciso7 = {
//        parent: ciso3,
//        text:{
//            name: "Kirkssssss Douglas",
//            title: "Chief Business Development Officer"
//        },
//        image: "../headshots/11.jpg"
//    }
//
//    chart_config = [
//        config,
//        ceo,
//        cto,
//        cbo,
//        cdo,
//        cio,
//        ciso,
//        cio2,
//        ciso2,
//        ciso3,
//        ciso4,
//        ciso5,
//        ciso6,
//        ciso7
//    ];




    // Another approach, same result
    // JSON approach

///*
    var chart_config = {
        chart: {
            container: "#basic-example",
            
            connectors: {
                type: 'step'
            },
            node: {
                HTMLclass: 'nodeExample1'
            }

        },
        nodeStructure: {
			collapsed: true,
            text: {
                name: "Mark Hill",
                title: "Chief executive officer",
                contact: "Tel: 01 213 123 134",
            },
            image: "../headshots/2.jpg",
            children: [
                {
					collapsed: true,
                    text:{
                        name: "Joe Linux",
                        title: "Chief Technology Officer",
                    },
                    stackChildren: true,
                    image: "../headshots/1.jpg",
                    children: [
                        {
                            text:{
                                name: "Ron Blomquist",
                                title: "Chief Information Security Officer"
                            },
                            image: "../headshots/8.jpg"
                        },
                        {
                            text:{
                                name: "Michael Rubin",
                                title: "Chief Innovation Officer",
                                contact: "we@aregreat.com"
                            },
                            image: "../headshots/9.jpg"
                        }
                    ]
                },
                {
					collapsed: true,
                    stackChildren: true,
                    text:{
                        name: "Linda May",
                        title: "Chief Business Officer",
                    },
                    image: "../headshots/5.jpg",
                    children: [
                        {
                            text:{
                                name: "Alice Lopez",
                                title: "Chief Communications Officer"
                            },
                            image: "../headshots/7.jpg"
                        },
                        {
                            text:{
                                name: "Mary Johnson",
                                title: "Chief Brand Officer"
                            },
                            image: "../headshots/4.jpg"
                        },
                        {
                            text:{
                                name: "Kirk Douglas",
                                title: "Chief Business Development Officer"
                            },
                            image: "../headshots/11.jpg"
                        }
                    ]
                },
                {
					collapsed: true,
                    stackChildren: true,				
                    text:{
                        name: "John Green",
                        title: "Chief accounting officer",
                        contact: "Tel: 01 213 123 134",
                    },
                    image: "../headshots/6.jpg",
                    children: [
                        {
                            text:{
                                name: "Erica Reel",
                                title: "Chief Customer Officer"
                            },
                            link: {
                                href: "http://www.google.com"
                            },
                            image: "../headshots/10.jpg"
                        }
                    ]
                }
            ]
        }
    };
