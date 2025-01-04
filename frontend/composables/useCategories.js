export const useCategories = () => {
  const categoryMap = {
    "pocitace": "Počítače",
    "mobily": "Mobily",
    "spotrebice": "Spotřebiče",
    "lednicky": "Ledničky",
    "pracky": "Pračky"
  }

  const getCategoryName = (slug) => {
    return categoryMap[slug] || slug.charAt(0).toUpperCase() + slug.slice(1)
  }

  return {
    categoryMap,
    getCategoryName
  }
} 