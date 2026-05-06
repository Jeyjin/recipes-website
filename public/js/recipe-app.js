function recipeApp() {
    return {
        myIngredients: [],
        selectedProduct: '',
        searchMode: 'all',
        recipes: [],
        displayedRecipes: [],
        currentPage: 1,
        itemsPerPage: 9,
        loading: false,
        searched: false,
        selectedRecipe: null,
        favorites: [],
        
        get totalPages() {
            return Math.ceil(this.recipes.length / this.itemsPerPage);
        },
        
        get startPage() {
            return Math.max(1, this.currentPage - 2);
        },
        
        get endPage() {
            return Math.min(this.totalPages, this.currentPage + 2);
        },
        
        get pages() {
            const pages = [];
            for (let i = this.startPage; i <= this.endPage; i++) {
                pages.push(i);
            }
            return pages;
        },
        
        init() {
            const saved = localStorage.getItem('myIngredients');
            if (saved) {
                this.myIngredients = JSON.parse(saved);
                if (this.myIngredients.length > 0) {
                    this.searchRecipes();
                }
            }
            this.loadFavorites();
            this.updateDisplayedRecipes();
        },
        
        updateDisplayedRecipes() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            this.displayedRecipes = this.recipes.slice(start, end);
        },
        
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.updateDisplayedRecipes();
                this.scrollToTop();
            }
        },
        
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.updateDisplayedRecipes();
                this.scrollToTop();
            }
        },
        
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        
        addProduct() {
            if (this.selectedProduct && !this.myIngredients.includes(this.selectedProduct)) {
                this.myIngredients.push(this.selectedProduct);
                localStorage.setItem('myIngredients', JSON.stringify(this.myIngredients));
                this.selectedProduct = '';
                this.searchRecipes();
            }
        },
        
        removeProduct(product) {
            this.myIngredients = this.myIngredients.filter(p => p !== product);
            localStorage.setItem('myIngredients', JSON.stringify(this.myIngredients));
            this.searchRecipes();
        },
        
        async searchRecipes() {
            this.loading = true;
            this.searched = true;
            
            let response = await fetch('/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    ingredients: this.myIngredients,
                    mode: this.searchMode
                })
            });
            
            let data = await response.json();
            this.recipes = data.recipes;
            this.currentPage = 1;
            this.updateDisplayedRecipes();
            this.loading = false;
        },
        
        showRecipeDetails(recipe) {
            this.selectedRecipe = recipe;
        },
        
        async toggleFavorite(recipeId) {
            if (this.isFavorite(recipeId)) {
                await fetch('/favorites/' + recipeId, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                this.favorites = this.favorites.filter(id => id !== recipeId);
            } else {
                await fetch('/favorites/' + recipeId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                this.favorites.push(recipeId);
            }
        },
        
        isFavorite(recipeId) {
            return this.favorites.includes(recipeId);
        },
        
        async loadFavorites() {
            let response = await fetch('/favorites/list');
            let data = await response.json();
            this.favorites = data;
        }
    }
}

window.recipeApp = recipeApp;