<div class="container">
    <div class="well well-sm">
        <h1>Catalog</h1>

    <div id="products" class="row list-group">
        <?php foreach ($products as $product): ?>
        <div class="item  col-xs-4 col-lg-4">
            <div class="thumbnail">
                <img class="group list-group-image" src="<?php echo $product['img_url']; ?>" alt="" />
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                        <?php echo $product['name']; ?></h4>
                    <p class="group inner list-group-item-text">
                        <?php echo $product['description']; ?></p>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead">
                                <?php echo $product['price']; ?></p>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <form action="/cart" method="post">
                                <input type="text">
                                <a class="btn btn-success" href="http://www.jquery2dotnet.com">Add to cart</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
       <?php endforeach;?>
    </div>
</div>

<style>
    .glyphicon { margin-right:5px; }
    .thumbnail
    {
        margin-bottom: 20px;
        padding: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
.list-group{
    display: flex;
flex-wrap: wrap;
    gap: 30px;
}
    .item
    {
        float: none;
        width: 400px;
        background-color: #fff;
        margin-bottom: 10px;
        img{
            width: 100%;
        }
    }
    .item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
    {
        background: #428bca;
    }

    .item.list-group-item .list-group-image
    {
        margin-right: 10px;
    }
    .item.list-group-item .thumbnail
    {
        margin-bottom: 0px;
    }
    .item.list-group-item .caption
    {
        padding: 9px 9px 0px 9px;
    }
    .item.list-group-item:nth-of-type(odd)
    {
        background: #eeeeee;
    }

    .item.list-group-item:before, .item.list-group-item:after
    {
        display: table;
        content: " ";
    }

    .item.list-group-item img
    {
        float: left;
    }
    .item.list-group-item:after
    {
        clear: both;
    }
    .list-group-item-text
    {
        margin: 0 0 11px;
    }

</style>