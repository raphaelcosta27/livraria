#!/bin/bash

# Caminho base (ajuste se necessário)
BASE_DIR=./resources/views

echo "Removendo prefixo 'tw-' das principais classes Tailwind em todos os arquivos Blade..."

# Array com os principais prefixos de classes Tailwind
CLASSES=(
  bg-
  text-
  font-
  px-
  py-
  pt-
  pb-
  pl-
  pr-
  mx-
  my-
  mt-
  mb-
  ml-
  mr-
  grid-
  gap-
  flex
  items-
  justify-
  rounded
  shadow
  border-
  w-
  h-
  min-w-
  min-h-
  max-w-
  max-h-
  leading-
  tracking-
  space-
  divide-
  z-
  object-
  overflow-
  transition
  duration-
  ease-
  cursor-
  select-
  opacity-
  focus:
  hover:
  active:
  disabled:
  group-
  sm:
  md:
  lg:
  xl:
  2xl:
)

# Para cada classe/prefixo, roda substituição para remover o 'tw-'
for class in "${CLASSES[@]}"
do
  echo "Revertendo 'tw-$class' para '$class'..."
  grep -rl "tw-$class" $BASE_DIR | xargs sed -i "s/\btw-$class/$class/g"
done

echo "Remoção do prefixo concluída!"
