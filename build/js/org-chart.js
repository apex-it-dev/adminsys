var config = {
       container: "#very-basic-example",
        rootOrientation: 'NORTH',
       connectors: {
           type: 'step',
           style: {
                "stroke-width": 1,
                "stroke": '#e3e6f0'
            }
       },
       node: {
           HTMLclass: 'card text-center',
            collapsable: true
       },
       
   },

   ceo = {
        collapsed:true,
       text: {
           name: "Mark Hill",
           title: "Chief executive officer",
           contact: "Tel: 01 213 123 134",
       },
       image: "headshots/2.jpg"
   },

   cto = {
       parent: ceo,
        collapsed: true,
       text:{
           name: "Joe Linux",
           title: "Chief Technology Officer",
       },
       stackChildren: true,
       image: "headshots/1.jpg"
   },
   cbo = {
       parent: ceo,
       stackChildren: true,
       collapsed: true,
       text:{
           name: "Linda May",
           title: "Chief Business Officer",
       },
       image: "headshots/5.jpg"
   },
   cdo = {
       parent: ceo,
       collapsed: true,
       text:{
           name: "John Green",
           title: "Chief accounting officer",
           contact: "Tel: 01 213 123 134",
       },
       image: "headshots/6.jpg"
   },
   cio = {
       parent: cto,
       collapsed: true,
       text:{
           name: "Ron Blomquist",
           title: "Chief Information Security Officer"
       },
       image: "headshots/8.jpg"
   },
   ciso = {
       parent: cto,
       collapsed: true,
       text:{
           name: "Michael Rubin",
           title: "Chief Innovation Officer",
           contact: {val: "we@aregreat.com", href: "mailto:we@aregreat.com"}
       },
       image: "headshots/9.jpg"
   },
   cio2 = {
       parent: cdo,
       collapsed: true,
       text:{
           name: "Erica Reel",
           title: "Chief Customer Officer"
       },
       link: {
           href: "http://www.google.com"
       },
       image: "headshots/10.jpg"
   },
   ciso2 = {
       parent: cbo,
       collapsed: true,
       text:{
           name: "Alice Lopez",
           title: "Chief Communications Officer"
       },
       image: "headshots/7.jpg"
   },

    ciso3 = {
       parent: cbo,
       collapsed: true,
       text:{
           name: "Mary Johnson",
           title: "Chief Brand Officer"
       },
       image: "headshots/4.jpg"
   },
   ciso4 = {
       parent: cbo,
       collapsed: true,
       text:{
           name: "Kirk Douglas",
           title: "Chief Business Development Officer"
       },
       image: "headshots/11.jpg"
   },
   ciso5 = {
       parent: ciso3,
       collapsed: true,
       text:{
           name: "Kirdsdasdk Douglas",
           title: "Chief Business Development Officer"
       },
       image: "headshots/11.jpg"
   },
   ciso6 = {
       parent: ciso3,
       collapsed: true,
       text:{
           name: "Kirkdsadads Douglas",
           title: "Chief Business Development Officer"
       },
       image: "headshots/11.jpg"
   },
   ciso7 = {
       parent: ciso3,
       collapsed: true,
       text:{
           name: "Kirkssssss Douglas",
           title: "Chief Business Development Officer"
       },
       image: "headshots/11.jpg"
   }

   chart_config = [
       config,
       ceo,
       cto,
       cbo,
       cdo,
       cio,
       ciso,
       cio2,
       ciso2,
       ciso3,
       ciso4,
       ciso5,
       ciso6,
       ciso7
   ];




    // Another approach, same result
    // JSON approach

///*
   //  var chart_config = {
   //      chart: {
   //          container: "#very-basic-example",
            
   //          connectors: {
   //              type: 'step',
            //  style: {
            //      "stroke-width": 1,
            //      "stroke": '#e3e6f0'
            //  }
   //          },
   //          node: {
   //              HTMLclass: "card text-center",
            //  collapsable: true
   //          }

   //      },
   //      nodeStructure: {
            // collapsed: true,
   //          text: {
   //              name: "Mark Hill",
   //              title: "Chief executive officer",
   //              desc: "Hong Kong",
   //          },
   //          image: "headshots/2.jpg",
   //          children: [
   //              {
            //      collapsed: true,
   //                  text:{
   //                      name: "Joe Linux",
   //                      title: "Chief Technology Officer",
   //                  },
   //                  stackChildren: false,
   //                  image: "headshots/1.jpg",
   //                  children: [
   //                      {
   //                          text:{
   //                              name: "Ron Blomquist",
   //                              title: "Chief Information Security Officer"
   //                          },
   //                          image: "headshots/8.jpg"
   //                      },
   //                      {
   //                          text:{
   //                              name: "Michael Rubin",
   //                              title: "Chief Innovation Officer",
   //                              contact: "we@aregreat.com"
   //                          },
   //                          image: "headshots/9.jpg"
   //                      }
   //                  ]
   //              },
   //              {
            //      collapsed: true,
   //                  stackChildren: false,
   //                  text:{
   //                      name: "Linda May",
   //                      title: "Chief Business Officer",
   //                  },
   //                  image: "headshots/5.jpg",
   //                  children: [
   //                      {
   //                          text:{
   //                              name: "Alice Lopez",
   //                              title: "Chief Communications Officer"
   //                          },
   //                          image: "headshots/7.jpg"
   //                      },
   //                      {
   //                          text:{
   //                              name: "Mary Johnson",
   //                              title: "Chief Brand Officer"
   //                          },
   //                          image: "headshots/4.jpg"
   //                      },
   //                      {
   //                          text:{
   //                              name: "Kirk Douglas",
   //                              title: "Chief Business Development Officer"
   //                          },
   //                          image: "headshots/11.jpg"
   //                      }
   //                  ]
   //              },
   //              {
            //      collapsed: true,
   //                  stackChildren: false,                
   //                  text:{
   //                      name: "John Green",
   //                      title: "Chief accounting officer",
   //                      contact: "Tel: 01 213 123 134",
   //                  },
   //                  image: "headshots/6.jpg",
   //                  children: [
   //                      {
   //                          text:{
   //                              name: "Erica Reel",
   //                              title: "Chief Customer Officer"
   //                          },
   //                          link: {
   //                              href: "http://www.google.com"
   //                          },
   //                          image: "headshots/10.jpg"
   //                      }
   //                  ]
   //              }
   //          ]
   //      }
   //  };
