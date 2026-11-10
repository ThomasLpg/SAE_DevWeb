<?php
namespace iutnc\iks\appli;
class Page {
    
    private ListePosts $listePosts;
    

    function __construct(private int $nbPostsParPage = 3){
        $this->listePosts = new ListePosts();
    }

    function __get(string $at) : mixed {
    if(property_exists($this, $at))
        return $this->$at;
        throw new \Exception("$at : invalid property");
    }


    function ajouterPost(Post $post) : int {
        if (count($this->listePosts->getListe()) >= $this->nbPostsParPage){
            return 0;
        }
        $this->listePosts->ajouterPost($post);
        return 1;
    }

    
}