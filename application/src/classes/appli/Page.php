<?php
namespace iutnc\iks\appli;
class Page {
    
    private ListePosts $listePosts;
    

    public function __construct(private int $nbPostsParPage = 3){
        $this->listePosts = new ListePosts();
    }

    public function __get(string $at) : mixed {
    if(property_exists($this, $at))
        return $this->$at;
        throw new \Exception("$at : invalid property");
    }


    public function ajouterPost(Post $post) : int {
        if (count($this->listePosts->getListe()) >= $this->nbPostsParPage){
            return 0;
        }
        $this->listePosts->ajouterPost($post);
        return 1;
    }

    
}